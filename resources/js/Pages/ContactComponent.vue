<template>
    <app-layout :title="$page.props.page_title">

        <div class="card mt-5" v-if="dataLoaded">
            <div class="card-header">
                <h4 class="card-title">
                    {{ $page.props.page_title }}
                </h4>
            </div>
            <form @submit.prevent="submit">
                <div class="card-body">
                    <div class="alert alert-success alert-dismissible fade show" role="alert"
                         v-if="$page.props.flash.success != null">
                        {{ $page.props.flash.success }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <div class="form-group mb-3">
                        <label for="name">
                            Name
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="name" class="form-control" required
                               :class="form.errors.name ? 'is-invalid' : ''"
                               id="name"
                               placeholder="Enter name" autofocus v-model="form.name">
                        <div class="text-danger" v-if="form.errors.name">{{ form.errors.name }}</div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">
                            Email
                            <span class="text-danger">*</span>
                        </label>
                        <input type="email" name="email" class="form-control"
                               :class="form.errors.email ? 'is-invalid' : ''" id="email" required
                               placeholder="Enter email" v-model="form.email">
                        <div class="text-danger" v-if="form.errors.email">{{ form.errors.email }}</div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="subject">
                            Subject
                            <span class="text-danger">*</span>
                        </label>
                        <input type="text" name="subject" class="form-control"
                               :class="form.errors.subject ? 'is-invalid' : ''" id="subject" required
                               placeholder="Enter subject" v-model="form.subject">
                        <div class="text-danger" v-if="form.errors.subject">{{ form.errors.subject }}</div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="subject">
                            Message
                            <span class="text-danger">*</span>
                        </label>
                        <textarea name="message" id="message" cols="30" rows="10" class="form-control"
                                  :class="form.errors.message ? 'is-invalid' : ''"
                                  placeholder="Enter message" v-model="form.message"></textarea>
                        <div class="text-danger" v-if="form.errors.message">{{ form.errors.message }}</div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary float-end" type="submit">
                        Send
                    </button>
                </div>
            </form>
        </div>
    </app-layout>
</template>

<script>
export default {
    name    : "ContactComponent",
    data    : () => ({
        dataLoaded : false,
        form       : {}
    }),
    methods : {
        submit() {
            this.form.post('/contacts', {
                preserveScroll : true,
                onSuccess      : () => this.form.reset(),
            })
        }
    },
    mounted() {
        this.form = this.$inertia.form({
            name    : '',
            email   : '',
            subject : '',
            message : ''
        });
        this.dataLoaded = true;
    }
}
</script>
