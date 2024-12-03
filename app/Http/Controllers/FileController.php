<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\File;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function store(Request $request)
    {
        // Validar los datos de entrada
        try {
            $request->validate([
                "name" => "required|string",
                "file" => "required|file|mimes:jpeg,png,jpg,gif,svg|max:2048" // Validar el archivo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "code" => 404,
                "status" => 'error',
                "message" => $e->getMessage(),
            ], 404);
        }

        // Subir archivo a S3
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = 'files/' . uniqid() . '.' . $file->getClientOriginalExtension();
            Storage::disk('s3')->put($filePath, file_get_contents($file));

            // Guardar la información del archivo en la base de datos
            File::create([
                'name' => $file->getClientOriginalName(),
                's3_name' => $filePath,
                'user_id' => Auth::user()->id,
            ]);
        }

        return response()->json([
            "code" => 200,
            "status" => 'success',
            "message" => "User registered and file uploaded successfully",
        ], 200);
    }


    public function getAllFile(Request $request)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Buscar los archivos por usuario
        $files = File::where('user_id', $user->id)->get();

        if ($files->isNotEmpty()) {
            $response = [];

            foreach ($files as $file) {
                // Obtener la URL temporal del archivo
                $fileUrl = Storage::disk('s3')->url($file->s3_name);
                // Intentar obtener el tamaño del archivo 
                try { 
                    $size = Storage::disk('s3')->size($file->s3_name); 
                } catch (\Exception $e) { 
                    $size = 'Unable to retrieve size'; 
                } 
              
              
                $response[] = [ 'name'=>$file->name,'file_url' => $fileUrl, 'file_metadata' => [ 'size' => $size, 'last_modified' => $file->updated_at, 'mime_type' => pathinfo($file->s3_name, PATHINFO_EXTENSION), ], ];
            }

            return response()->json(['status' => "success", 'files' => $response], 200);
        } else {
            return response()->json(['message' => 'Files not found '], 404);
        }
    }



    public function deleteFile($fileName)
    {
        // Obtener el usuario autenticado
        $user = Auth::user();

        // Buscar el archivo por nombre y usuario
        $file = File::where('s3_name', 'files/' . $fileName)->where('user_id', $user->id)->first();

        if ($file) {
            // Eliminar el archivo del disco S3, pero no lo voy a eliminar
            //Storage::disk('s3')->delete($file->s3_name);

            // Eliminar el registro por softdelete
            $file->delete();

            return response()->json(['message' => 'File deleted successfully']);
        } else {
            return response()->json(['message' => 'File not found or access denied'], 404);
        }
    }
}
