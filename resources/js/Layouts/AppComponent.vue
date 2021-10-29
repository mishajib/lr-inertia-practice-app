<template>
    <div class="container">
        <head-component>
            <title>{{ title || 'Your Page Title' }} | Inertia App</title>
        </head-component>
        <div class="row">
            <div class="col-md-12">
                <nav class="navbar navbar-expand-lg navbar-light bg-light">
                    <div class="container-fluid">
                        <inertia-link class="navbar-brand" href="/">Navbar</inertia-link>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup"
                                aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                            <div class="navbar-nav">
                                <inertia-link class="nav-link" :class="{ 'active': $page.url === '/' }" href="/">
                                    Home
                                </inertia-link>
                                <inertia-link class="nav-link" :class="{ 'active': $page.url === '/about' }"
                                              href="/about">
                                    About
                                </inertia-link>
                                <inertia-link class="nav-link" :class="{ 'active': $page.url === '/contacts' }"
                                              href="/contacts">
                                    Contact
                                </inertia-link>
                            </div>
                        </div>
                    </div>
                </nav>

                <main>
                    <slot/>
                </main>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name  : "AppComponent",
    props : {
        title : {
            type     : String,
            required : false,
        }
    },
}
</script>

