<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Rumah Sakit') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">

                <!-- Alert Messages -->
                <div id="alertMessage" class="hidden mb-4 p-4 rounded-md"></div>

                <!-- Button Tambah -->
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4"
                    onclick="openModal('add')">
                    <i class="fas fa-plus mr-2"></i> Tambah Rumah Sakit
                </button>

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table id="rumahsakitTable" class="min-w-full bg-white">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Rumah Sakit</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Alamat</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Email</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Telepon</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($rumahsakit as $index => $rs)
                                <tr id="row-{{ $rs->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $index + 1 }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $rs->nama_rumah_sakit }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $rs->alamat }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $rs->email }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $rs->telepon }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button
                                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded mr-2"
                                            onclick="editData({{ $rs->id }})" title="Edit Data">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>
                                        <button
                                            class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded"
                                            onclick="deleteData({{ $rs->id }})" title="Hapus Data">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Tidak ada data rumah sakit
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Form -->
    <div id="formModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4" id="modalTitle">Tambah Rumah Sakit</h3>

                <form id="rumahsakitForm">
                    @csrf
                    <input type="hidden" id="id" name="id">
                    <input type="hidden" id="method" name="_method" value="POST">

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="nama_rumah_sakit">
                            Nama Rumah Sakit <span class="text-red-500">*</span>
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="nama_rumah_sakit" name="nama_rumah_sakit" type="text" required
                            placeholder="Masukkan nama rumah sakit">
                        <span class="text-red-500 text-xs" id="error-nama_rumah_sakit"></span>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="alamat">
                            Alamat <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="alamat" name="alamat" rows="3" required placeholder="Masukkan alamat lengkap"></textarea>
                        <span class="text-red-500 text-xs" id="error-alamat"></span>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="email" name="email" type="email" required placeholder="Masukkan email">
                        <span class="text-red-500 text-xs" id="error-email"></span>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="telepon">
                            Telepon <span class="text-red-500">*</span>
                        </label>
                        <input
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                            id="telepon" name="telepon" type="text" required placeholder="Masukkan nomor telepon">
                        <span class="text-red-500 text-xs" id="error-telepon"></span>
                    </div>

                    <div class="flex items-center justify-end space-x-2">
                        <button type="button"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                            onclick="closeModal()">
                            Batal
                        </button>
                        <button type="submit" id="submitBtn"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                            <span id="submitText">Simpan</span>
                            <span id="loadingText" class="hidden">
                                <i class="fas fa-spinner fa-spin"></i> Loading...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                    <i class="fas fa-exclamation-triangle text-red-600"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mt-4">Konfirmasi Hapus</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">
                        Apakah Anda yakin ingin menghapus data rumah sakit ini?
                        Data yang dihapus tidak dapat dikembalikan.
                    </p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmDelete"
                        class="px-4 py-2 bg-red-500 text-white text-base font-medium rounded-md w-24 mr-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-300">
                        Hapus
                    </button>
                    <button onclick="closeConfirmModal()"
                        class="px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-24 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <script>
            let deleteId = null;

            // Open Modal Function
            function openModal(type, id = null) {
                clearErrors();

                if (type === 'add') {
                    document.getElementById('modalTitle').textContent = 'Tambah Rumah Sakit';
                    document.getElementById('submitText').textContent = 'Simpan';
                    document.getElementById('rumahsakitForm').reset();
                    document.getElementById('id').value = '';
                    document.getElementById('method').value = 'POST';
                } else if (type === 'edit') {
                    document.getElementById('modalTitle').textContent = 'Edit Rumah Sakit';
                    document.getElementById('submitText').textContent = 'Update';
                    document.getElementById('method').value = 'PUT';
                }

                document.getElementById('formModal').classList.remove('hidden');
            }

            // Close Modal Function
            function closeModal() {
                document.getElementById('formModal').classList.add('hidden');
                clearErrors();
            }

            // Close Confirm Modal
            function closeConfirmModal() {
                document.getElementById('confirmModal').classList.add('hidden');
                deleteId = null;
            }

            // Clear Error Messages
            function clearErrors() {
                const errorElements = document.querySelectorAll('[id^="error-"]');
                errorElements.forEach(element => {
                    element.textContent = '';
                });

                // Remove error styling
                const inputElements = document.querySelectorAll('input, textarea');
                inputElements.forEach(element => {
                    element.classList.remove('border-red-500');
                });
            }

            // Show Alert Message
            function showAlert(message, type = 'success') {
                const alertDiv = document.getElementById('alertMessage');
                alertDiv.className =
                    `mb-4 p-4 rounded-md ${type === 'success' ? 'bg-green-100 border-green-500 text-green-700' : 'bg-red-100 border-red-500 text-red-700'}`;
                alertDiv.textContent = message;
                alertDiv.classList.remove('hidden');

                // Auto hide after 5 seconds
                setTimeout(() => {
                    alertDiv.classList.add('hidden');
                }, 5000);
            }

            // Edit Data Function
            function editData(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.get(`/rumahsakit/${id}/edit`, function(response) {
                    if (response.success) {
                        const data = response.data;
                        $('#id').val(data.id);
                        $('#nama_rumah_sakit').val(data.nama_rumah_sakit);
                        $('#alamat').val(data.alamat);
                        $('#email').val(data.email);
                        $('#telepon').val(data.telepon);
                        openModal('edit', id);
                    } else {
                        showAlert(response.message, 'error');
                    }
                }).fail(function() {
                    showAlert('Gagal mengambil data', 'error');
                });
            }

            // Delete Data Function
            function deleteData(id) {
                deleteId = id;
                document.getElementById('confirmModal').classList.remove('hidden');
            }

            // Confirm Delete
            document.getElementById('confirmDelete').addEventListener('click', function() {
                if (deleteId) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: `/rumahsakit/${deleteId}`,
                        type: 'DELETE',
                        success: function(response) {
                            closeConfirmModal();
                            if (response.success) {
                                showAlert(response.message, 'success');
                                $(`#row-${deleteId}`).fadeOut('slow', function() {
                                    $(this).remove();
                                    updateRowNumbers();
                                });
                            } else {
                                showAlert(response.message, 'error');
                            }
                        },
                        error: function(xhr) {
                            closeConfirmModal();
                            const response = xhr.responseJSON;
                            showAlert(response?.message || 'Gagal menghapus data', 'error');
                        }
                    });
                }
            });

            // Update Row Numbers
            function updateRowNumbers() {
                $('#rumahsakitTable tbody tr').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                });
            }

            // Form Submit Handler
            $('#rumahsakitForm').submit(function(e) {
                e.preventDefault();
                clearErrors();

                const submitBtn = document.getElementById('submitBtn');
                const submitText = document.getElementById('submitText');
                const loadingText = document.getElementById('loadingText');

                // Show loading state
                submitBtn.disabled = true;
                submitText.classList.add('hidden');
                loadingText.classList.remove('hidden');

                const id = $('#id').val();
                const url = id ? `/rumahsakit/${id}` : '/rumahsakit';
                const method = id ? 'PUT' : 'POST';

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        // Reset button state
                        submitBtn.disabled = false;
                        submitText.classList.remove('hidden');
                        loadingText.classList.add('hidden');

                        if (response.success) {
                            closeModal();
                            showAlert(response.message, 'success');

                            // Reload page after short delay to show updated data
                            setTimeout(() => {
                                location.reload();
                            }, 1500);
                        } else {
                            showAlert(response.message, 'error');
                        }
                    },
                    error: function(xhr) {
                        // Reset button state
                        submitBtn.disabled = false;
                        submitText.classList.remove('hidden');
                        loadingText.classList.add('hidden');

                        const response = xhr.responseJSON;

                        if (xhr.status === 422 && response.errors) {
                            // Show validation errors
                            Object.keys(response.errors).forEach(key => {
                                const errorElement = document.getElementById(`error-${key}`);
                                if (errorElement) {
                                    errorElement.textContent = response.errors[key][0];
                                    document.getElementById(key).classList.add('border-red-500');
                                }
                            });
                        } else {
                            showAlert(response?.message || 'Terjadi kesalahan!', 'error');
                        }
                    }
                });
            });

            // Close modal when clicking outside
            document.getElementById('formModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeModal();
                }
            });

            document.getElementById('confirmModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeConfirmModal();
                }
            });
        </script>
    @endpush
</x-app-layout>
