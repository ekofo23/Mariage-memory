@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="font-serif fw-bold text-dark mb-0">Gestion de l'Album Photo</h3>
            <p class="text-muted small mb-0">Gérez, modifiez ou supprimez les photos affichées aux invités.</p>
        </div>
        <a href="{{ route('admin.photos.create') }}" class="btn btn-wedding">
            <i class="fa-solid fa-plus me-1"></i> Ajouter une Photo
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Aperçu</th>
                        <th>Titre / Code</th>
                        <th>Catégorie</th>
                        <th class="text-center">Téléchargements</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($photos as $photo)
                        <tr>
                            <td class="ps-4" style="width: 100px;">
                                <img src="{{ asset($photo->thumbnail_path) }}" alt="{{ $photo->title }}" class="rounded-3" style="width: 70px; height: 50px; object-fit: cover;">
                            </td>
                            <td>
                                <strong class="text-dark d-block">{{ $photo->title }}</strong>
                                <small class="text-muted">{{ $photo->code ?? 'Sans code' }}</small>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border fw-normal">{{ $photo->category->name ?? 'Général' }}</span>
                            </td>
                            <td class="text-center">
                                <span class="badge rounded-pill bg-danger text-white"><i class="fa-solid fa-download me-1"></i> {{ $photo->download_count }}</span>
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.photos.edit', $photo->id) }}" class="btn btn-sm btn-outline-primary rounded-circle me-1" title="Modifier">
                                    <i class="fa-solid fa-pen"></i>
                                </a>
                                
                                <form action="{{ route('admin.photos.destroy', $photo->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette photo ?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Supprimer">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                Aucune photo dans l'album pour le moment.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($photos->hasPages())
            <div class="card-footer bg-white border-0 py-3">
                {{ $photos->links() }}
            </div>
        @endif
    </div>
</div>
@endsection