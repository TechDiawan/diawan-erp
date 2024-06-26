<template>
    <div>
        <!-- breadcrumbs Start -->
        <breadcrumbs :items="breadcrumbs" :current="breadcrumbsCurrent" />
        <!-- breadcrumbs end -->
        <div class="row">
            <div class="col-md-6 m-auto">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            {{ $t('backup.page_title') }}
                        </h3>
                        <router-link
                            :to="{ name: 'home' }"
                            class="btn btn-dark float-right"
                        >
                            <i class="fas fa-long-arrow-alt-left" />
                            {{ $t('common.back') }}
                        </router-link>
                    </div>
                    <div class="card-body">
                        <form
                            class="form-horizontal"
                            @submit.prevent="databaseBackup"
                            @keydown="form.onKeydown($event)"
                        >
                            <div class="form-group row">
                                <label
                                    for="format"
                                    class="col-sm-2 col-form-label"
                                    >{{ $t('backup.format') }}
                                    <span class="required">*</span></label
                                >
                                <div class="col-sm-10">
                                    <select
                                        v-model="form.format"
                                        class="form-control"
                                        :class="{
                                            'is-invalid':
                                                form.errors.has('format'),
                                        }"
                                        id="format"
                                    >
                                        <option value="sql">
                                            {{ $t('backup.format_sql') }}
                                        </option>
                                    </select>
                                    <has-error :form="form" field="format" />
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="offset-sm-2 col-sm-10">
                                    <v-button
                                        :loading="form.busy"
                                        class="btn btn-primary"
                                    >
                                        <i class="fas fa-file-export" />
                                        {{ $t('backup.export') }}
                                    </v-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Form from 'vform';
export default {
    middleware: ['auth', 'check-permissions'],
    metaInfo() {
        return { title: this.$t('backup.page_title') };
    },
    data: () => ({
        isDemoMode: window.config.isDemoMode,
        breadcrumbsCurrent: 'backup.breadcrumbs_current',
        breadcrumbs: [
            {
                name: 'backup.breadcrumbs_first',
                url: 'home',
            },
            {
                name: 'backup.breadcrumbs_active',
                url: '',
            },
        ],
        form: new Form({
            format: 'sql',
        }),
        loading: true,
        user: '',
    }),
    methods: {
        // create backup
        async databaseBackup() {
            if (this.isDemoMode) {
                return toast.fire({
                    type: 'warning',
                    title: this.$t(
                        'You are not allowed to do this in demo version.'
                    ),
                });
            }
            await this.form
                .post(window.location.origin + '/api/backup', {
                    responseType: 'blob',
                })
                .then((response) => {
                    var fileURL = window.URL.createObjectURL(
                        new Blob([response.data])
                    );
                    var fileLink = document.createElement('a');
                    fileLink.href = fileURL;
                    // add readable date and time to file name
                    var fileName =
                        'backup_' +
                        new Date().toLocaleString() +
                        '.' +
                        this.form.format;
                    fileLink.setAttribute('download', fileName);
                    document.body.appendChild(fileLink);
                    fileLink.click();
                    toast.fire({
                        type: 'success',
                        title: this.$t('backup.success_msg'),
                    });
                })
                .catch(() => {
                    toast.fire({
                        type: 'error',
                        title: this.$t('common.error_msg'),
                    });
                });
        },
    },
};
</script>

<style lang="scss" scoped></style>
