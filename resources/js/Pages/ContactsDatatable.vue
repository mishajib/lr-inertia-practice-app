<template>
    <app-layout :title="$page.props.page_title">

        <div class="card mt-5" v-if="dataLoaded">
            <div class="card-header">
                <h4 class="card-title">
                    {{ $page.props.page_title }}
                </h4>
            </div>
            <div class="card-body">
                <Datatable
                    :url="datatableUrl"
                    :headers="datatableHeaders"
                    :columns="datatableColumns"
                />
            </div>
        </div>
    </app-layout>
</template>

<script>
import Datatable from './Datatable';

export default {
    name       : "ContactsDatatable",
    props      : ['datatableUrl', 'datatableColumns', 'datatableHeaders'],
    components : {
        Datatable
    },
    data       : () => ({
        dataLoaded : false
    }),
    mounted() {
        this.dataLoaded = true;
    }
}
</script>
