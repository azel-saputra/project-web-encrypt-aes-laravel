<?php

namespace App\Http\Controllers;

use App\Models\EncryptedFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;


class FileEncryptionController extends Controller
{
    public function encrypt(Request $request){
        $file = EncryptedFile::All();
        return view('encrypt', compact('file'));
     }

     public function decrypt(Request $request){
        $user_id = auth()->id();
        $file = EncryptedFile::where('user_id', $user_id)->get();
        return view('decrypt', compact('file'));
     }

     public function dashboard(){
        $user_id = auth()->id();
        $file = EncryptedFile::where('user_id', $user_id)->get();
        $count = $this->countDecryptedData();
        return view('dashboard', compact('file', 'count'));
     }

     public function countDecryptedData()
    {
        $user_id = auth()->id();
        $count = EncryptedFile::where('user_id', $user_id)->count();
        return $count;
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file|mimes:pdf,doc,docx,xls,xlsx',
            'encryption_key' => 'required|min:8',
            'deskripsi' => 'required',
        ]);
        

        //memasukkan file
        $file = $request->file('file');
        $originalFilename = $file->getClientOriginalName();

        try {
            //melakukan generate nama file menjadi random
            $encryptedFilename = Str::random(40) . '.enc';

            //mengambil inputan
            $encryptionKey = $request->input('encryption_key');
            $deskripsiInput = $request->input('deskripsi');

            //Melakukan encrypt file
            $encryptedFile = $this->encryptFile($file->getRealPath(), $encryptionKey);

            //Memasukkan file ke dalam storage local
            Storage::disk('encrypted_files')->put($encryptedFilename, $encryptedFile);

            //mengambil size file
            $originalFileSize = $file->getSize();

            //Memasukkan file kedalan database
            $encryptedFileModel = EncryptedFile::create([
                'filename' => $originalFilename,
                'encrypted_file' => $encryptedFilename,
                'encryption_key' => Hash::make($encryptionKey),
                'deskripsi' => $deskripsiInput,
                'user_id' => auth()->id(),
                'file_size' => $originalFileSize,
            ]);

            return redirect()->back();
           
        } catch (\Exception $exception) {
            //error handle
            throw ValidationException::withMessages([
                'encryption_key' => 'Unable to encrypt the file.',
            ]);
        }
    }

    /**
     * Decrypt and download the file from the database.
     *
     * @param  int  $id
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function download(Request $request, $id)
    {
        //mengambil id file
        $encryptedFile = EncryptedFile::findOrFail($id);

        //melakukan check id user yang login
        if ($encryptedFile->user_id != auth()->id()) {
            return redirect()->back()->withErrors(['You are not authorized to download this file.']);
        }

        if ($request->has('decryption_key')) {

            //mengambil inputan key
            $key = $request->input('decryption_key');
    
            //melakukan decrypt file
            $decryptedFile = $this->decryptFile($encryptedFile->encrypted_file, $key);
    
            //mencocokan nama file yang ada didatabase
            $decryptedFilename = $encryptedFile->filename;
    
            //Memasukkan file ke temporary
            Storage::disk('local')->put($decryptedFilename, $decryptedFile);
    
            return response()->download(storage_path('app/' . $decryptedFilename))->deleteFileAfterSend(true);
        } else {
            //error handle
            return redirect()->back()->withErrors(['Please enter the decryption key.']);
        }
    }

    /**
     * Encrypt a file using AES.
     *
     * @param  string  $path
     * @param  string  $key
     * @return string
     */
    private function encryptFile($path, $key)
    {
        //mengambil path file
        $fileContents = file_get_contents($path);

        //melakukan encrypt file menggunakan metode AES dengan 256 bit dan mode CBC
        $iv = random_bytes(openssl_cipher_iv_length('AES-256-CBC'));
        $encryptedData = openssl_encrypt($fileContents, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);

        return $iv . $encryptedData;
        Session::flash('success', 'File encrypted and stored successfully.');

    }

    /**
     * Decrypt a file using AES.
     *
     * @param  string  $filename
     * @param  string  $key
     * @return string
     */
    private function decryptFile($filename, $key)
    {
        //mengambil file dalam storage
        $fileContents = Storage::disk('encrypted_files')->get($filename);

        //melakukan decrypt file menggunakan metode AES dengan 256 bit dan mode CBC
        $ivLength = openssl_cipher_iv_length('AES-256-CBC');
        $iv = substr($fileContents, 0, $ivLength);
        $encryptedData = substr($fileContents, $ivLength);

        return openssl_decrypt($encryptedData, 'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv);
    }

    public function delete($id)
        {
            // Mengambil data file yang akan dihapus
            $file = EncryptedFile::findOrFail($id);

            // Memeriksa apakah user yang login memiliki akses untuk menghapus file
            if ($file->user_id != auth()->id()) {
                return redirect()->back()->withErrors(['You are not authorized to delete this file.']);
            }

            try {
                // Menghapus file dari storage
                Storage::disk('encrypted_files')->delete($file->encrypted_file);

                // Menghapus data file dari database
                $file->delete();

                return redirect()->route('decrypt')->with('success', 'File has been deleted successfully.');
            } catch (\Exception $exception) {
                // Handle error
                return redirect()->back()->withErrors(['Unable to delete the file.']);
            }
        }


}
