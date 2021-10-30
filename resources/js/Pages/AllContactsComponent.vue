<template>
    <app-layout :title="$page.props.page_title">

        <div class="card mt-5" v-if="dataLoaded">
            <div class="card-header">
                <h4 class="card-title">
                    {{ $page.props.page_title }}

                    <input type="text" class="form-control" v-model="query" @input="searchHandler"
                           placeholder="Search here....">
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>#SL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(contact, index) in contacts.data" :key="index">
                            <td>{{ contacts.per_page * (contacts.current_page - 1) + index + 1 }}</td>
                            <td>{{ contact.name }}</td>
                            <td>{{ contact.email }}</td>
                            <td>{{ contact.subject }}</td>
                            <td>{{ contact.message }}</td>
                            <td>
                                <inertia-link class="btn btn-primary" :href="'/contacts/'+ contact.id +'/edit'">
                                    Edit
                                </inertia-link>

                                <inertia-link class="btn btn-danger" :href="'/contacts/'+ contact.id" method="delete"
                                              as="button" type="button">
                                    Delete
                                </inertia-link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <pagination :links="contacts.links"></pagination>
            </div>
        </div>
    </app-layout>
</template>

<script>
export default {
    name    : "ContactComponent",
    props   : {
        contacts : Object,
        required : true
    },
    data    : () => ({
        dataLoaded : false,
        query      : '',
    }),
    methods : {
        searchHandler() {
            if (this.query === '') {
                this.$inertia.replace('/contacts');
            } else {
                this.$inertia.replace('/contacts?query=' + this.query);
            }
        },
    },
    mounted() {
        this.dataLoaded = true;
    }
}
</script>
