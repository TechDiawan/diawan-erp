<template>
  <div>
    <!-- breadcrumbs Start -->
    <breadcrumbs :items="breadcrumbs" :current="breadcrumbsCurrent" />
    <!-- breadcrumbs end -->
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              {{ $t('setup.permissions.edit.form_title') }}
            </h3>
            <router-link :to="{ name: 'permissions.index' }" class="btn btn-dark float-right">
              <i class="fas fa-long-arrow-alt-left" /> {{ $t('common.back') }}
            </router-link>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" @submit.prevent="updatePermission" @keydown="form.onKeydown($event)">
            <div class="card-body">
              <div class="row">
                <div class="form-group col-md-12">
                  <label for="name">{{ $t('common.name') }}
                    <span class="required">*</span></label>
                  <input id="name" v-model="form.name" type="text" class="form-control"
                    :class="{ 'is-invalid': form.errors.has('name') }" name="name"
                    :placeholder="$t('common.name_placeholder')" />
                  <has-error :form="form" field="name" />
                </div>
                <div class="form-group col-md-6">
                  <label for="guardName">{{ $t('setup.permissions.common.guard_name') }}
                    <span class="required">*</span></label>
                  <input id="guardName" v-model="form.guardName" type="text" class="form-control"
                    :class="{ 'is-invalid': form.errors.has('guardName') }" name="guardName" :placeholder="$t('setup.permissions.common.guard_name_placeholder')
                      " />
                  <has-error :form="form" field="guardName" />
                </div>
                <div class="form-group col-md-6">
                  <label for="slug">{{ $t('setup.permissions.common.slug') }}
                    <span class="required">*</span></label>
                  <input id="slug" v-model="form.slug" type="text" class="form-control"
                    :class="{ 'is-invalid': form.errors.has('slug') }" name="slug" :placeholder="$t('setup.permissions.common.slug_placeholder')
                      " />
                  <has-error :form="form" field="slug" />
                </div>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <v-button :loading="form.busy" class="btn btn-primary">
                <i class="fas fa-edit" /> {{ $t('common.save_changes') }}
              </v-button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Form from 'vform'
import axios from 'axios'

export default {
  middleware: ['auth', 'check-permissions'],
  metaInfo() {
    return { title: this.$t('setup.permissions.edit.page_title') }
  },
  data: () => ({
    breadcrumbsCurrent: 'setup.permissions.edit.breadcrumbs_current',
    breadcrumbs: [
      {
        name: 'setup.permissions.edit.breadcrumbs_first',
        url: 'home',
      },
      {
        name: 'setup.permissions.edit.breadcrumbs_second',
        url: 'setup.index',
      },
      {
        name: 'setup.permissions.edit.breadcrumbs_third',
        url: 'permissions.index',
      },
      {
        name: 'setup.permissions.edit.breadcrumbs_active',
        url: '',
      },
    ],
    form: new Form({
      name: '',
      guardName: '',
      slug: '',
    }),
    loading: true,
  }),
  created() {
    this.getPermission()
  },
  methods: {
    // get permission
    async getPermission() {
      const { data } = await axios.get(
        window.location.origin + '/api/permissions/' + this.$route.params.slug
      )
      this.form.name = data.data.name
      this.form.guardName = data.data.guardName
      this.form.slug = data.data.slug
    },

    // update permission
    async updatePermission() {
      await this.form
        .patch(
          window.location.origin + '/api/permissions/' + this.$route.params.slug
        )
        .then(() => {
          toast.fire({
            type: 'success',
            title: this.$t('setup.permissions.edit.success_msg'),
          })
          this.$router.push({ name: 'permissions.index' })
        })
        .catch(() => {
          toast.fire({
            type: 'error',
            title: this.$t('common.error_msg'),
          })
        })
    },
  },
}
</script>

<style lang="scss" scoped></style>
