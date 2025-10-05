<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $client = new Client();
        $url = "https://buku-api.test/api/buku";
        $response = $client->request('GET', $url);
        // echo $response->getStatusCode(); // debug kode status
        $data = json_decode($response->getBody()->getContents(), true);
        // dd($data);

        return view('buku.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tanggal_publikasi' => 'required|date',
        ],[
            'judul.required' => 'Judul wajib diisi',
            'pengarang.required' => 'Pengarang wajib diisi',
            'tanggal_publikasi.required' => 'Tanggal publikasi wajib diisi',
            'tanggal_publikasi.date' => 'Tanggal publikasi berformat tanggal',
        ]);

        $params = $request->only(['judul', 'pengarang', 'tanggal_publikasi']);

        $client = new Client();
        $url = "https://buku-api.test/api/buku";
        $response = $client->request('POST', $url, [
            'json' => $params
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        // dd($data);

        // error handling
        if (!$data['status']) {
            return back()->with('error', $data['message']); // tambah withInput() utk mengembalikan data ke form, tpi sudah tersedia old() di blade
            // return redirect()->to('buku')->withErrors($data['data']);
        }

        // return redirect()->to('buku')->with('success', $data['message']);
        return back()->with('success', $data['message']); // lebih sederhana
    }

    /**
     * Display the specified resource.
     */
    public function show(Buku $buku)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $client = new Client();
        $url = "https://buku-api.test/api/buku/$id";
        $response = $client->request('GET', $url);
        $data = json_decode($response->getBody()->getContents(), true);
        // echo $id;
        // dd($data);

        if($data['status'] != true){
            return redirect()->to('buku')->withErrors($data['message']); 
        } else {
            return view('buku.index', ['data' => $data['data']]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'pengarang' => 'required|string|max:255',
            'tanggal_publikasi' => 'required|date',
        ],[
            'judul.required' => 'Judul wajib diisi',
            'pengarang.required' => 'Pengarang wajib diisi',
            'tanggal_publikasi.required' => 'Tanggal publikasi wajib diisi',
            'tanggal_publikasi.date' => 'Tanggal publikasi berformat tanggal',
        ]);

        $params = $request->only(['judul', 'pengarang', 'tanggal_publikasi']);

        $client = new Client();
        $url = "https://buku-api.test/api/buku/$id";
        $response = $client->request('PUT', $url, [
            'json' => $params
        ]);

        $data = json_decode($response->getBody()->getContents(), true);
        // dd($data);

        // error handling
        if (!$data['status']) {
            return back()->with('error', $data['message']); // tambah withInput() utk mengembalikan data ke form, tpi sudah tersedia old() di blade
            // return redirect()->to('buku')->withErrors($data['data']);
        }

        return redirect()->to('buku')->with('success', $data['message']); // fungsi back() dipake klo kembali ke halaman yang sama, gunakan to() untuk kembali ke halaman tertentu jika selesai mengerjakan
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $client = new Client();
        $url = "https://buku-api.test/api/buku/$id";
        $response = $client->request('DELETE', $url);

        $data = json_decode($response->getBody()->getContents(), true);
        // dd($data);

        // error handling
        if ($data['status'] != true) {
            return redirect()->to('buku')->withErrors($data['message']);
        }

        return back()->with('success', $data['message']);  // fungsi back() dipake klo kembali ke halaman yang sama, gunakan to() untuk kembali ke halaman tertentu jika selesai mengerjakan
    }
}
