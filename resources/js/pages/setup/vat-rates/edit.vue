<template>
  <div>
    <!-- breadcrumbs Start -->
    <breadcrumbs :items="breadcrumbs" :current="breadcrumbsCurrent" />
    <!-- breadcrumbs end -->
    <div class="row">
      <div class="col-12 col-xl-3">
        <SettingsSidebar />
      </div>
      <div class="col-12 col-xl-9">
        <form role="form" @submit.prevent="updateVATRate" @keydown="form.onKeydown($event)">
          <div class="card">
            <div class="card-header setings-header">
              <div class="col-xl-4 col-4">
                <h3 class="card-title">
                  {{ $t("setup.vat_rates.edit.form_title") }}
                </h3>
              </div>
              <div class="col-xl-8 col-8 float-right text-right">
                <router-link :to="{ name: 'vatRates.index' }" class="btn btn-dark float-right">
                  <i class="fas fa-long-arrow-alt-left" />
                  {{ $t("common.back") }}
                </router-link>
              </div>
            </div>
            <div class="card-body">
              <div class="form-group">
                <label for="name">{{ $t("common.name") }}
                  <span class="required">*</span></label>
                <input id="name" v-model="form.name" type="text" class="form-control"
                  :class="{ 'is-invalid': form.errors.has('name') }" name="name"
                  :placeholder="$t('common.name_placeholder')" />
                <has-error :form="form" field="name" />
              </div>
              <div class="form-group">
                <label for="code">{{ $t("setup.common.sort_code") }}
                  <span class="required">*</span></label>
                <input id="code" v-model="form.code" type="text" class="form-control"
                  :class="{ 'is-invalid': form.errors.has('code') }" name="code"
                  :placeholder="$t('common.code_placeholder')" />
                <has-error :form="form" field="code" />
              </div>
              <div class="form-group">
                <label for="rate">{{ $t("setup.vat_rates.common.rate_in_percent") }}
                  <span class="required">*</span></label>
                <input id="rate" v-model="form.rate" type="number" class="form-control"
                  :class="{ 'is-invalid': form.errors.has('rate') }" name="rate"
                  :placeholder="$t('setup.vat_rates.common.rate_palceholder')" />
                <has-error :form="form" field="rate" />
              </div>
              <div class="form-group">
                <label for="status">{{ $t("common.status") }}</label>
                <select id="status" v-model="form.status" class="form-control"
                  :class="{ 'is-invalid': form.errors.has('status') }">
                  <option value="1">{{ $t("common.active") }}</option>
                  <option value="0">{{ $t("common.in_active") }}</option>
                </select>
                <has-error :form="form" field="status" />
              </div>

              <div class="form-group">
                <label for="note">{{ $t("common.note") }}</label>
                <textarea id="note" v-model="form.note" class="form-control"
                  :class="{ 'is-invalid': form.errors.has('note') }" :placeholder="$t('common.note_placeholder')" />
                <has-error :form="form" field="note" />
              </div>
            </div>
            <div class="card-footer">
              <v-button :loading="form.busy" class="btn btn-primary">
                <i class="fas fa-edit" /> {{ $t("common.save_changes") }}
              </v-button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import Form from "vform";
import axios from "axios";

export default {
  middleware: ["auth", "check-permissions"],
  metaInfo() {
    return { title: this.$t("setup.vat_rates.edit.page_title") };
  },
  data: () => ({
    breadcrumbsCurrent: "setup.vat_rates.edit.breadcrumbs_current",
    breadcrumbs: [
      {
        name: "setup.vat_rates.edit.breadcrumbs_first",
        url: "home",
      },
      {
        name: "setup.vat_rates.edit.breadcrumbs_second",
        url: "setup.index",
      },
      {
        name: "setup.vat_rates.edit.breadcrumbs_third",
        url: "vatRates.index",
      },
      {
        name: "setup.vat_rates.edit.breadcrumbs_active",
        url: "",
      },
    ],
    form: new Form({
      name: "",
      note: "",
      code: "",
      rate: "",
      status: 1,
    }),
    loading: true,
  }),

  mounted() {
    this.getVATRate();
  },
  methods: {
    // get category
    async getVATRate() {
      const { data } = await axios.get(
        window.location.origin + "/api/vat-rates/" + this.$route.params.slug
      );
      this.form.name = data.data.name;
      this.form.code = data.data.code;
      this.form.rate = data.data.rate;
      this.form.note = data.data.note;
      this.form.status = data.data.status;
    },
    // update category
    async updateVATRate() {
      await this.form
        .patch(
          window.location.origin + "/api/vat-rates/" + this.$route.params.slug
        )
        .then(() => {
          toast.fire({
            type: "success",
            title: this.$t("setup.vat_rates.edit.success_msg"),
          });
          this.$router.push({ name: "vatRates.index" });
        })
        .catch(() => {
          toast.fire({
            type: "error",
            title: this.$t("common.error_msg"),
          });
        });
    },
  },
};
</script>
