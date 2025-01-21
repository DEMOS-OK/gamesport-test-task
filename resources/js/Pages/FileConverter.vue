<template>
  <AppLayout title="File Converter">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        CSV to JSON
      </h2>
    </template>

    <div class="py-12">
      <div v-if="!userCanConvertFiles" class="py-3 px-5">
        <p class="bg-amber-50 p-3 border-r-4">
          The download is available for users who have registered 10 or more days ago.
          You can upload files every 5 minutes.
        </p>
      </div>

      <div v-if="userCanConvertFiles" class="py-3 max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
          <form :action="route('convert-csv-to-json')" class="flex flex-col space-y-4"
                enctype="multipart/form-data" method="POST">
            <label class="font-bold" for="file">Select a CSV file:</label>
            <input id="file" accept=".csv" class="border p-2" name="file" type="file">

            <label class="font-bold" for="title">Title:</label>
            <input id="title" class="border p-2" name="title" type="text">

            <div class="flex items-center">
              <input id="is_private" class="mr-2" name="is_private" type="checkbox">
              <label class="font-bold" for="is_private">Is private?</label>
            </div>

            <input :value="csrf" name="_token" type="hidden">

            <button class="py-2 px-4 bg-blue-500 text-white rounded-lg" type="submit">Convert to JSON</button>
          </form>
        </div>
      </div>

      <div class="mt-6 px-3">
        <h3 class="font-bold text-lg mb-2">Uploaded Files:</h3>
        <table class="w-full">
          <thead>
          <tr>
            <th>Date & Time</th>
            <th>Source File Name</th>
            <th>Conversion Status</th>
            <th>Is Public</th>
            <th>Author Id</th>
            <th>Download JSON</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="file in visibleFiles" :key="file.id">
            <td>{{ formatDate(file.created_at) }}</td>
            <td>{{ file.sourceTitle }}</td>
            <td>{{ getStatusDescription(file.status) }}</td>
            <td>{{ !file.isPrivate }}</td>
            <td>{{ file.userId }}</td>
            <td>
              <a v-if="file.status === 3" :href="downloadLink(file.id)">Download</a>
            </td>
          </tr>
          </tbody>
        </table>
      </div>

    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

import {ref} from 'vue';

const csrf = ref(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

const props = defineProps({
  visibleFiles: {
    type: Array,
    required: true
  },
  userCanConvertFiles: {
    type: Boolean,
    required: true
  }
});

const downloadLink = (fileId) => {
  return `/file-converter/download/${fileId}`;
};

const getStatusDescription = (status) => {
  switch (status) {
    case 1:
      return 'PENDING';
    case 2:
      return 'PROCESSING';
    case 3:
      return 'FINISHED';
    case 4:
      return 'FAILED';
    default:
      return 'Unknown';
  }

};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  const options = {
    year: 'numeric', month: '2-digit', day: '2-digit',
    hour: '2-digit', minute: '2-digit', second: '2-digit'
  };

  return date.toLocaleString('en-US', options);
};
</script>

<style>
label {
  font-size: 1.1rem;
}

input, button {
  width: 100%;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th, td {
  border: 1px solid #e2e8f0;
  padding: 8px;
  text-align: left;
}

th {
  background-color: #f8f9fa;
  font-weight: bold;
}

tr:nth-child(even) {
  background-color: #f9f9f9;
}
</style>