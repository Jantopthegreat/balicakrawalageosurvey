
@extends('admin.layout')

@section('title', 'Kelola Kontak')
@section('main-class', 'admin-dashboard')
@section('content')

<div class="admin-contact-page">

    {{-- PAGE HEADER --}}
    <header class="admin-dashboard-header">

        <div class="admin-dashboard-title">

            <svg viewBox="0 0 24 24"
                fill="none"
                stroke="currentColor"
                stroke-width="1.8"
                stroke-linecap="round"
                stroke-linejoin="round">

                <rect x="3" y="5" width="18" height="14" rx="2"/>
                <path d="m3 7 9 6 9-6"/>
                <path d="M7 2h10"/>

            </svg>

            <h1>Kontak</h1>

        </div>

        <p>
            Kelola informasi kontak perusahaan yang ditampilkan pada website.
        </p>

    </header>


    {{-- SUCCESS MESSAGE --}}
    @if (session('status'))
        <div class="admin-contact-success" role="status">
            <span>✓</span>
            {{ session('status') }}
        </div>
    @endif


    {{-- CONTACT SECTION --}}
    <section class="dashboard-section">

        <div class="admin-contact-section-header">

            <div>
                <h2 class="dashboard-section-title">
                    Data Kontak
                </h2>

                <p class="admin-contact-subtitle">
                    Informasi kontak yang digunakan oleh website.
                </p>
            </div>

            @if ($contacts->total() === 0)
                <a
                    class="admin-contact-add"
                    href="{{ route('admin.contact.create') }}"
                >
                    <span>+</span>
                    Tambah Kontak
                </a>
            @endif

        </div>


        {{-- CONTACT TABLE --}}
        <div class="admin-contact-table-wrap">

            <div class="admin-contact-table-header">
                <h3>Daftar Kontak</h3>
                <span>{{ $contacts->total() }} data</span>
            </div>

            <div class="admin-contact-table-scroll">

                <table class="admin-contact-table">

                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nomor WhatsApp</th>
                            <th>Alamat</th>
                            <th>Dibuat</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($contacts as $contact)

                            <tr>

                                <td class="contact-name">
                                    <strong>{{ $contact->name }}</strong>

                                    @if ($loop->first && $contacts->currentPage() === 1)
                                        <span class="contact-latest-badge">
                                            Terbaru
                                        </span>
                                    @endif
                                </td>

                                <td data-label="Email">
                                    {{ $contact->email }}
                                </td>

                                <td data-label="Nomor WhatsApp">
                                    {{ $contact->no_hp }}
                                </td>

                                <td data-label="Alamat">
                                    {{ $contact->alamat }}
                                </td>

                                <td data-label="Dibuat">
                                    {{ $contact->created_at->format('d M Y H:i') }}
                                </td>

                                <td class="contact-actions-cell">

                                    <div class="admin-contact-actions">

                                        <a
                                            href="{{ route('admin.contact.edit', $contact) }}"
                                            class="admin-contact-edit"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('admin.contact.destroy', $contact) }}"
                                            onsubmit="return confirm('Hapus data kontak ini? Jika ini data terbaru, website akan memakai data kontak sebelumnya atau nomor default.')"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="admin-contact-delete"
                                            >
                                                Hapus
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6">

                                    <div class="admin-contact-empty">

                                        <span class="admin-contact-empty-icon">
                                            <svg viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="1.6">
                                                <rect x="3" y="5" width="18" height="14" rx="2"/>
                                                <path d="m3 7 9 6 9-6"/>
                                            </svg>
                                        </span>

                                        <strong>Belum ada data kontak</strong>

                                        <p>
                                            Tambahkan informasi kontak agar
                                            website dapat menampilkan nomor
                                            WhatsApp perusahaan.
                                        </p>

                                        <a href="{{ route('admin.contact.create') }}"
                                            class="admin-contact-add">
                                            + Tambah Kontak
                                        </a>

                                    </div>

                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PAGINATION --}}
            @if ($contacts->hasPages())
                <div class="admin-contact-pagination">
                    {{ $contacts->links() }}
                </div>
            @endif

        </div>

    </section>

</div>

@endsection
