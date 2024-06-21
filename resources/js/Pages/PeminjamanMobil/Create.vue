<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import { defineProps } from "vue";
import { ref } from "vue";

defineProps({
    mobils: {
        type: Array,
    },
});

const form = useForm({
    mobil_id: "",
    tanggal_peminjaman: "",
    tanggal_pengembalian: "",
});

const submit = () => {
    form.post(route("peminjaman.store"), {
        onFinish: () =>
            form.reset(
                "mobil_id",
                "tanggal_peminjaman",
                "tanggal_pengembalian"
            ),
    });
};
</script>

<template>
    <Head title="Pinjam Mobil" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Pinjam Mobil
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label
                                    for="mobil_id"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Mobil
                                </label>
                                <select
                                    v-model="form.mobil_id"
                                    id="mobil_id"
                                    name="mobil_id"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                >
                                    <option value="">Pilih Mobil</option>
                                    <option
                                        v-for="mobil in mobils"
                                        :key="mobil.id"
                                        :value="mobil.id"
                                    >
                                        {{ mobil.merk }} {{ mobil.model }} -
                                        {{ mobil.nomor_plat }} (Tarif per Hari:
                                        {{ mobil.tarif_per_hari }})
                                    </option>
                                </select>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label
                                    for="tanggal_peminjaman"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Tanggal Peminjaman
                                </label>
                                <input
                                    v-model="form.tanggal_peminjaman"
                                    type="date"
                                    name="tanggal_peminjaman"
                                    id="tanggal_peminjaman"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                />
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label
                                    for="tanggal_pengembalian"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Tanggal Pengembalian
                                </label>
                                <input
                                    v-model="form.tanggal_pengembalian"
                                    type="date"
                                    name="tanggal_pengembalian"
                                    id="tanggal_pengembalian"
                                    class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                />
                            </div>
                        </div>

                        <div class="flex justify-end mt-4">
                            <button
                                type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                            >
                                Pinjam Mobil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
