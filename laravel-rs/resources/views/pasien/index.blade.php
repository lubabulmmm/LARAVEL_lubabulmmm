<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Pasien') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                <div class="flex justify-between mb-4">
                    <select id="filter_rs" class="border rounded px-3 py-2">
                        <option value="">Semua Rumah Sakit</option>
                        @foreach ($rumahsakit as $rs)
                            <option value="{{ $rs->id }}">{{ $rs->nama_rumah_sakit }}</option>
                        @endforeach
                    </select>

                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        onclick="openModal()">
                        Tambah Pasien
                    </button>
                </div>

                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Nama Pasien</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Alamat</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left">No Telepon</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Rumah Sakit</th>
                            <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pasienTable">
                        @foreach ($pasien as $p)
                            <tr data-id="{{ $p->id }}">
                                <td class="px-6 py-4 border-b border-gray-300">{{ $p->nama_pasien }}</td>
                                <td class="px-6 py-4 border-b border-gray-300">{{ $p->alamat }}</td>
                                <td class="px-6 py-4 border-b border-gray-300">{{ $p->no_telepon }}</td>
                                <td class="px-6 py-4 border-b border-gray-300">{{ $p->rumahSakit->nama_rumah_sakit }}
                                </td>
                                <td class="px-6 py-4 border-b border-gray-300">
                                    <button
                                        class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded"
                                        onclick="editData({{ $p->id }})">
                                        Edit
                                    </button>
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
                                        onclick="deleteData({{ $p->id }})">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="formModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <form id="pasienForm">
                @csrf
                <input type="hidden" id="id" name="id">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_pasien">
                        Nama Pasien
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                        id="nama_pasien" name="nama_pasien" type="text" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="alamat">
                        Alamat
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                        id="alamat" name="alamat" type="text" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="no_telepon">
                        No Telepon
                    </label>
                    <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                        id="no_telepon" name="no_telepon" type="text" required>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="rumah_sakit_id">
                        Rumah Sakit
                    </label>
                    <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                        id="rumah_sakit_id" name="rumah_sakit_id" required>
                        <option value="">Pilih Rumah Sakit</option>
                        @foreach ($rumahsakit as $rs)
                            <option value="{{ $rs->id }}">{{ $rs->nama_rumah_sakit }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center justify-end">
                    <button type="button"
                        class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2"
                        onclick="closeModal()">
                        Batal
                    </button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            // Setup AJAX CSRF Token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function openModal() {
                $('#id').val('');
                $('#pasienForm').trigger('reset');
                $('#formModal').removeClass('hidden');
            }

            function closeModal() {
                $('#formModal').addClass('hidden');
            }

            function editData(id) {
                $.ajax({
                    url: `/pasien/${id}/edit`,
                    type: 'GET',
                    success: function(response) {
                        $('#id').val(response.id);
                        $('#nama_pasien').val(response.nama_pasien);
                        $('#alamat').val(response.alamat);
                        $('#no_telepon').val(response.no_telepon);
                        $('#rumah_sakit_id').val(response.rumah_sakit_id);
                        openModal();
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            }

            function deleteData(id) {
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    $.ajax({
                        url: `/pasien/${id}`,
                        type: 'DELETE',
                        success: function(response) {
                            if (response.success) {
                                alert(response.message);
                                $(`tr[data-id="${id}"]`).remove();
                            }
                        },
                        error: function(xhr) {
                            alert('Error: ' + xhr.responseJSON.message);
                        }
                    });
                }
            }

            $('#filter_rs').change(function() {
                let id = $(this).val();
                if (id) {
                    $.ajax({
                        url: `/pasien/rumahsakit/${id}`,
                        type: 'GET',
                        success: function(response) {
                            updateTable(response);
                        },
                        error: function(xhr) {
                            alert('Error: ' + xhr.responseJSON.message);
                        }
                    });
                } else {
                    location.reload();
                }
            });

            function updateTable(data) {
                let html = '';
                data.forEach(function(p) {
                    html += `
                <tr data-id="${p.id}">
                    <td class="px-6 py-4 border-b border-gray-300">${p.nama_pasien}</td>
                    <td class="px-6 py-4 border-b border-gray-300">${p.alamat}</td>
                    <td class="px-6 py-4 border-b border-gray-300">${p.no_telepon}</td>
                    <td class="px-6 py-4 border-b border-gray-300">${p.rumah_sakit.nama_rumah_sakit}</td>
                    <td class="px-6 py-4 border-b border-gray-300">
                        <button class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded"
                                onclick="editData(${p.id})">
                            Edit
                        </button>
                        <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
                                onclick="deleteData(${p.id})">
                            Hapus
                        </button>
                    </td>
                </tr>
            `;
                });
                $('#pasienTable').html(html);
            }

            $('#pasienForm').submit(function(e) {
                e.preventDefault();
                let id = $('#id').val();
                let url = id ? `/pasien/${id}` : '/pasien';
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        if (response.success) {
                            alert(response.message);
                            closeModal();
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        alert('Error: ' + xhr.responseJSON.message);
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
