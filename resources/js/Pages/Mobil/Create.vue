<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = useForm({
    merk: "",
    model: "",
    nomor_plat: "",
    tarif_per_hari: "",
});

const submit = () => {
    form.post(route("mobil.store"), {
        onFinish: () =>
            form.reset("merk", "model", "nomor_plat", "tarif_per_hari"),
    });
};
</script>

<template>
    <Head title="Tambah Mobil" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tambah Mobil
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <form @submit.prevent="submit">
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label
                                    for="merk"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Merk
                                </label>
                                <input
                                    type="text"
                                    name="merk"
                                    id="merk"
                                    v-model="form.merk"
                                    autocomplete="merk"
                                    required
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label
                                    for="model"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Model
                                </label>
                                <input
                                    type="text"
                                    name="model"
                                    id="model"
                                    v-model="form.model"
                                    autocomplete="model"
                                    required
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label
                                    for="nomor_plat"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Plat Nomor
                                </label>
                                <input
                                    type="text"
                                    name="nomor_plat"
                                    id="nomor_plat"
                                    v-model="form.nomor_plat"
                                    autocomplete="plat_nomor"
                                    required
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                />
                            </div>

                            <div class="col-span-6 sm:col-span-3">
                                <label
                                    for="tarif_per_hari"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Harga
                                </label>
                                <input
                                    type="number"
                                    name="tarif_per_hari"
                                    id="tarif_per_hari"
                                    v-model="form.tarif_per_hari"
                                    autocomplete="tarif_per_hari"
                                    required
                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                />

                                <p class="mt-2 text-sm text-gray-500">
                                    Tarif per hari
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-end mt-4">
                            <PrimaryButton
                                type="submit"
                                class="ms-4"
                                :class="{ 'opacity-25': form.processing }"
                                :disabled="form.processing"
                            >
                                Tambah Mobil
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
