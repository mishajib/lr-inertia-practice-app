<template>
    <nav aria-label="...">
        <ul class="pagination justify-content-center" v-if="links.length > 3">

            <div v-for="(link, index) in links" :key="index">
                <li style="cursor: pointer;" class="page-item" v-if="link.url === null"
                    :class="{ disabled: link.url === null }">
                    <inertia-link class="page-link" v-html="link.label">
                        <span v-if="link.active" class="sr-only">(current)</span>
                    </inertia-link>
                </li>

                <li style="cursor: pointer;" class="page-item" v-else
                    :class="link.active ? 'active' : ''">
                    <inertia-link class="page-link" :href="link.url" v-html="link.label">
                        <span v-if="link.active" class="sr-only">(current)</span>
                    </inertia-link>
                </li>
            </div>
        </ul>
    </nav>
</template>

<script>
export default {
    props : {
        links    : Array,
        required : true
    }
}
</script>
