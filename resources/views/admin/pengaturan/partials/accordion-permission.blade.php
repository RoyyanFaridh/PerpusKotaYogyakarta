@if (!$user->isSuperAdmin() && auth()->user()->isSuperAdmin())
    <tr id="permission-row-{{ $user->id }}" class="hidden">
        <td colspan="8" class="px-5 pb-4 pt-1">
            <div class="rounded-2xl border border-neutral-100 bg-neutral-50 overflow-hidden">
                <div class="px-5 py-3.5 border-b border-neutral-100 flex items-center justify-between bg-white">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-primary-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        <p class="text-sm font-semibold text-neutral-700">Hak Akses — {{ $user->nama }}</p>
                    </div>
                    <button type="button" onclick="togglePermission({{ $user->id }})"
                            aria-label="Tutup hak akses"
                            class="p-1 rounded-lg text-neutral-300 hover:text-neutral-500 hover:bg-neutral-100 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>
                <form method="POST" action="{{ route('admin.pengaturan.user.permissions', $user) }}"
                      class="px-5 py-5">
                    @csrf
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                        @foreach ($allPermissions as $modul => $permissions)
                            <div class="flex flex-col gap-2">
                                <p class="text-xs font-semibold text-neutral-400 uppercase tracking-wide">{{ $modul }}</p>
                                <div class="flex flex-col gap-1">
                                    @foreach ($permissions as $permission)
                                        @php
                                            $label = match(true) {
                                                str_ends_with($permission, '.create') => 'Tambah',
                                                str_ends_with($permission, '.edit')   => 'Edit',
                                                str_ends_with($permission, '.delete') => 'Hapus',
                                                default => $permission,
                                            };
                                            $checked = in_array($permission, $user->getPermissionList());
                                        @endphp
                                        <label class="flex items-center gap-2 px-2.5 py-1.5 rounded-lg bg-white border {{ $checked ? 'border-primary-200 text-primary-700' : 'border-neutral-100 text-neutral-500' }} cursor-pointer hover:border-primary-200 hover:text-primary-700 transition-colors">
                                            <input type="checkbox"
                                                   name="permissions[]"
                                                   value="{{ $permission }}"
                                                   {{ $checked ? 'checked' : '' }}
                                                   class="w-3 h-3 rounded accent-primary-500 shrink-0">
                                            <span class="text-xs">{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-end mt-4 pt-3 border-t border-neutral-100">
                        <button type="submit"
                                class="px-4 py-2 text-sm font-medium rounded-lg bg-primary-600 text-white hover:bg-primary-700 transition-colors">
                            Simpan Hak Akses
                        </button>
                    </div>
                </form>
            </div>
        </td>
    </tr>
@endif