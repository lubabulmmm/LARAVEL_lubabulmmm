<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="py-12">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4"
                                onclick="openModal()">
                                Tambah Rumah Sakit
                            </button>

                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Nama Rumah Sakit</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Alamat</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Email</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Telepon</th>
                                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($rumahsakit as $rs)
                                        <tr>
                                            <td class="px-6 py-4 border-b border-gray-300">{{ $rs->nama_rumah_sakit }}
                                            </td>
                                            <td class="px-6 py-4 border-b border-gray-300">{{ $rs->alamat }}</td>
                                            <td class="px-6 py-4 border-b border-gray-300">{{ $rs->email }}</td>
                                            <td class="px-6 py-4 border-b border-gray-300">{{ $rs->telepon }}</td>
                                            <td class="px-6 py-4 border-b border-gray-300">
                                                <button
                                                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded"
                                                    onclick="editData({{ $rs->id }})">
                                                    Edit
                                                </button>
                                                <button
                                                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded"
                                                    onclick="deleteData({{ $rs->id }})">
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
                        <form id="rumahsakitForm">
                            @csrf
                            <input type="hidden" id="id" name="id">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_rumah_sakit">
                                    Nama Rumah Sakit
                                </label>
                                <input
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                                    id="nama_rumah_sakit" name="nama_rumah_sakit" type="text" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="alamat">
                                    Alamat
                                </label>
                                <input
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                                    id="alamat" name="alamat" type="text" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                    Email
                                </label>
                                <input
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                                    id="email" name="email" type="email" required>
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="telepon">
                                    Telepon
                                </label>
                                <input
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
                                    id="telepon" name="telepon" type="text" required>
                            </div>
                            <div class="flex items-center justify-end">
                                <button type="button"
                                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2"
                                    onclick="closeModal()">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                @push('scripts')
                    <script>
                        function openModal() {
                            document.getElementById('rumahsakitForm').reset();
                            document.getElementById('formModal').classList.remove('hidden');
                        }

                        function closeModal() {
                            document.getElementById('formModal').classList.add('hidden');
                        }

                        function editData(id) {
                            $.get(`/rumahsakit/${id}/edit`, function(data) {
                                $('#id').val(data.id);
                                $('#nama_rumah_sakit').val(data.nama_rumah_sakit);
                                $('#alamat').val(data.alamat);
                                $('#email').val(data.email);
                                $('#telepon').val(data.telepon);
                                openModal();
                            });
                        }

                        function deleteData(id) {
                            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                                $.ajax({
                                    url: `/rumahsakit/${id}`,
                                    type: 'DELETE',
                                    data: {
                                        "_token": "{{ csrf_token() }}"
                                    },
                                    success: function(response) {
                                        alert(response.success);
                                        location.reload();
                                    }
                                });
                            }
                        }

                        $('#rumahsakitForm').submit(function(e) {
                            e.preventDefault();
                            let id = $('#id').val();
                            let url = id ? `/rumahsakit/${id}` : '/rumahsakit';
                            let method = id ? 'PUT' : 'POST';

                            $.ajax({
                                url: url,
                                type: method,
                                data: $(this).serialize(),
                                success: function(response) {
                                    alert(response.success);
                                    location.reload();
                                },
                                error: function(response) {
                                    alert('Terjadi kesalahan!');
                                }
                            });
                        });
                    </script>
                @endpush
            </div>
        </div>
    </div>
</x-app-layout>
