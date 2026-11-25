<?php

namespace App\Http\Controllers;

use App\Models\Catatan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CatatanController extends Controller
{
    private function rules(): array
    {
        return [
            'judul'    => 'required|string|max:255',
            'isi'      => 'required|string',
            'tanggal'  => 'required|date_format:Y-m-d',
            'kategori' => 'required|in:Kuliah,Tugas,Pribadi,Lainnya',
        ];
    }

    private function cari(string $id): ?Catatan
    {
        if (!ctype_digit($id)) {
            return null;
        }
        return Catatan::find($id);
    }

    private function notFound(): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => 'Catatan tidak ditemukan',
        ], 404);
    }

    // GET /api/catatan
    public function index(): JsonResponse
    {
        $data = Catatan::orderByDesc('tanggal')->orderByDesc('id')->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar catatan berhasil diambil',
            'data'    => $data,
        ], 200);
    }

    // GET /api/catatan/{id}
    public function show(string $id): JsonResponse
    {
        $catatan = $this->cari($id);
        if (!$catatan) {
            return $this->notFound();
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail catatan berhasil diambil',
            'data'    => $catatan,
        ], 200);
    }

    // POST /api/catatan
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate($this->rules());
        $catatan = Catatan::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Catatan berhasil ditambahkan',
            'data'    => $catatan,
        ], 201);
    }

    // PUT /api/catatan/{id}
    public function update(Request $request, string $id): JsonResponse
    {
        $catatan = $this->cari($id);
        if (!$catatan) {
            return $this->notFound();
        }

        $validated = $request->validate($this->rules());
        $catatan->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Catatan berhasil diperbarui',
            'data'    => $catatan->fresh(),
        ], 200);
    }

    // DELETE /api/catatan/{id}
    public function destroy(string $id): JsonResponse|Response
    {
        $catatan = $this->cari($id);
        if (!$catatan) {
            return $this->notFound();
        }

        $catatan->delete();

        return response()->noContent(); // 204 tanpa isi
    }
}