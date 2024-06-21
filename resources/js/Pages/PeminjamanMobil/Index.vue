<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { defineProps } from "vue";
import { ref } from "vue";

defineProps({
    peminjamans: {
        type: Array,
    },
});

const form = useForm({});

const kembalikan = (id) => {
    if (confirm("Apakah Anda yakin ingin mengembalikan mobil ini?")) {
        form.put(route("peminjaman.update", { id }), {
            onFinish: () => {
                form.reset();
            },
        });
    }
};

const search = ref("");
</script>

<template>
    <AuthenticatedLayout>
        <Head title="Peminjaman Mobil" />

        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Peminjaman Mobil
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="flex justify-start">
                        <input
                            type="text"
                            class="border border-gray-300 rounded-md p-2"
                            placeholder="Cari peminjaman..."
                            v-model="search"
                        />

                        <Link
                            :href="
                                route('peminjaman.index', {
                                    search: search,
                                })
                            "
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2"
                        >
                            Cari
                        </Link>
                    </div>
                    <div class="flex justify-end">
                        <Link
                            :href="route('peminjaman.create')"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                        >
                            Pinjam Mobil
                        </Link>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200 mt-4">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    ID
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Mobil
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Tanggal Mulai
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Tanggal Selesai
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Total Harga
                                </th>
                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Status
                                </th>

                                <th
                                    scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
                                >
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr
                                v-for="(peminjaman, index) in peminjamans"
                                :key="peminjaman.id"
                            >
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ peminjaman.id }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ peminjaman.mobil.merk }}
                                    {{ peminjaman.mobil.model }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ peminjaman.tanggal_peminjaman }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ peminjaman.tanggal_pengembalian }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ peminjaman.total_harga }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ peminjaman.status }}
                                </td>
                                <td
                                    class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium"
                                >
                                    <button
                                        @click="kembalikan(peminjaman.id)"
                                        class="text-red-600 hover:text-red-900"
                                    >
                                        Kembalikan
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
