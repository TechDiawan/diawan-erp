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
              {{ $t('products.list.create.form_title') }}
            </h3>
            <router-link :to="{ name: 'products.index' }" class="btn btn-dark float-right">
              <i class="fas fa-long-arrow-alt-left" /> {{ $t('common.back') }}
            </router-link>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form role="form" @submit.prevent="saveProduct" @keydown="form.onKeydown($event)">
            <div class="card-body">
              <div class="row">
                <div class="form-group col-md-6 col-xl-6">
                  <label for="itemName">{{ $t('common.item_name') }}
                    <span class="required">*</span></label>
                  <input id="itemName" v-model="form.itemName" type="text" class="form-control"
                    :class="{ 'is-invalid': form.errors.has('itemName') }" name="itemName"
                    :placeholder="$t('common.item_name_placeholder')" />
                  <has-error :form="form" field="itemName" />
                </div>
                <div class="form-group col-md-6 col-xl-3">
                  <label for="itemModel">{{ $t('common.item_model') }}</label>
                  <input id="itemModel" v-model="form.itemModel" type="text" class="form-control"
                    :class="{ 'is-invalid': form.errors.has('itemModel') }" name="itemModel"
                    :placeholder="$t('common.item_model_placeholder')" />
                  <has-error :form="form" field="itemModel" />
                </div>
                <div class="form-group col-md-6 col-xl-3">
                  <div class="input-group">
                    <label for="itemCode" class="col-md-12">{{ $t('common.item_code') }}
                      <span class="required">*</span></label>
                    <div class="input-group-prepend">
                      <span v-if="prefix" class="input-group-text" id="basic-addon1">{{ prefix }}</span>
                    </div>
                    <input v-model="form.itemCode" type="text" class="form-control"
                      :class="{ 'is-invalid': form.errors.has('itemCode') }" name="itemCode"
                      :placeholder="$t('common.item_code_placeholder')" aria-label="itemCode"
                      aria-describedby="basic-addon1" />
                    <has-error :form="form" field="itemCode" />
                  </div>
                </div>
                <div class="form-group col-md-6 col-xl-4">
                  <label for="barcodeSymbology">{{ $t('products.list.common.barcode_symbology') }}
                    <span class="required">*</span></label>
                  <select id="barcodeSymbology" v-model="form.barcodeSymbology" class="form-control" :class="{
                    'is-invalid': form.errors.has('barcodeSymbology'),
                  }">
                    <option value="CODE128">CODE128</option>
                    <option value="CODE39">CODE39</option>
                    <option value="EAN8">EAN8</option>
                    <option value="EAN13">EAN13</option>
                    <option value="UPC">UPC</option>
                  </select>
                  <has-error :form="form" field="barcodeSymbology" />
                </div>
                <div v-if="items" class="form-group col-md-6 col-xl-4">
                  <label for="subCategory">{{ $t('common.sub_category') }}
                    <span class="required">*</span></label>
                  <v-select v-model="form.subCategory" :options="items" label="name"
                    :class="{ 'is-invalid': form.errors.has('subCategory') }" name="subCategory"
                    :placeholder="$t('common.category_name_placeholder')" />
                  <has-error :form="form" field="subCategory" />
                </div>
                <div v-if="brands" class="form-group col-md-6 col-xl-4">
                  <label for="brand">{{ $t('common.brand') }}</label>
                  <v-select v-model="form.brand" :options="brands" label="name"
                    :class="{ 'is-invalid': form.errors.has('brand') }" name="brand"
                    :placeholder="$t('common.brand_placeholder')" />
                  <has-error :form="form" field="brand" />
                </div>
                <div v-if="units" class="form-group col-md-6 col-xl-4">
                  <label for="itemUnit">{{ $t('common.unit') }}
                    <span class="required">*</span></label>
                  <v-select v-model="form.itemUnit" :options="units" label="name"
                    :class="{ 'is-invalid': form.errors.has('itemUnit') }" name="itemUnit"
                    :placeholder="$t('common.unit_placeholder')" />
                  <has-error :form="form" field="itemUnit" />
                </div>
                <div v-if="taxes" class="form-group col-md-6 col-xl-4">
                  <label for="productTax">{{ $t('products.list.common.product_tax') }}
                    <span class="required">*</span></label>
                  <v-select v-model="form.productTax" :options="taxes" label="code"
                    :class="{ 'is-invalid': form.errors.has('productTax') }" name="productTax"
                    :placeholder="$t('products.list.common.tax_placeholder')" @input="calculatePrice" />
                  <has-error :form="form" field="productTax" />
                </div>
                <div class="form-group col-md-6 col-xl-4">
                  <label for="taxType">{{ $t('products.list.common.tax_type') }}
                    <span class="required">*</span></label>
                  <select id="taxType" v-model="form.taxType" class="form-control"
                    :class="{ 'is-invalid': form.errors.has('taxType') }" @change="calculatePrice">
                    <option value="Exclusive">
                      {{ $t('products.list.common.exclusive') }}
                    </option>
                    <option value="Inclusive">
                      {{ $t('products.list.common.inclusive') }}
                    </option>
                  </select>
                  <has-error :form="form" field="taxType" />
                </div>
                <div class="form-group col-md-6 col-xl-4">
                  <label for="regularPrice">{{ $t('products.list.common.regular_price') }}
                    <span class="required">*</span></label>
                  <input id="regularPrice" v-model="form.regularPrice" type="number" step="any" min="0"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('regularPrice') }" name="regularPrice"
                    :placeholder="$t('products.list.common.regular_price_placeholder')
                      " @change="calculatePrice" @keyup="calculatePrice" />
                  <has-error :form="form" field="regularPrice" />
                </div>
                <div class="form-group col-md-6 col-xl-4">
                  <div class="input-group">
                    <label for="discount" class="col-md-12">{{
                      $t('common.discount')
                    }}</label>
                    <input v-model="form.discount" type="number" min="0" max="100" class="form-control"
                      :class="{ 'is-invalid': form.errors.has('discount') }" name="discount"
                      :placeholder="$t('common.discount_placeholder')" aria-label="discount"
                      aria-describedby="basic-addon1" @change="calculatePrice" @keyup="calculatePrice" />
                    <div class="input-group-prepend">
                      <span class="input-group-text" id="basic-addon1">%</span>
                    </div>
                    <has-error :form="form" field="discount" />
                  </div>
                </div>
                <div class="form-group col-md-6 col-xl-4">
                  <label for="sellingPrice">{{
                    $t('products.list.common.selling_price')
                  }}</label>
                  <input id="sellingPrice" v-model="form.sellingPrice" type="number" class="form-control" readonly
                    :class="{ 'is-invalid': form.errors.has('sellingPrice') }" name="sellingPrice" :placeholder="$t('products.list.common.selling_price_placeholder')
                        " />
                  <has-error :form="form" field="sellingPrice" />
                </div>
                <div class="form-group col-md-12">
                  <label for="note">{{ $t('common.note') }}</label>
                  <textarea id="note" v-model="form.note" type="text" class="form-control"
                    :class="{ 'is-invalid': form.errors.has('note') }" name="companyName"
                    :placeholder="$t('common.note_placeholder')"></textarea>
                  <has-error :form="form" field="note" />
                </div>
                <div class="form-group col-md-6 col-xl-4">
                  <label for="alertQuantity">{{ $t('products.list.common.alert_quantity') }}
                  </label>
                  <input id="alertQuantity" v-model="form.alertQuantity" type="number" min="0" max="1000"
                    class="form-control" :class="{ 'is-invalid': form.errors.has('alertQuantity') }" name="alertQuantity"
                    :placeholder="$t('products.list.common.alert_quantity_placeholder')
                      " />
                  <has-error :form="form" field="alertQuantity" />
                </div>
                <div class="form-group col-md-6 col-xl-4">
                  <label for="status">{{ $t('common.status') }}</label>
                  <select id="status" v-model="form.status" class="form-control"
                    :class="{ 'is-invalid': form.errors.has('status') }">
                    <option value="1">
                      {{ $t('common.active') }}
                    </option>
                    <option value="0">
                      {{ $t('common.in_active') }}
                    </option>
                  </select>
                  <has-error :form="form" field="status" />
                </div>
                <div class="form-group col-md-6 col-xl-4">
                  <label for="image">{{ $t('common.image') }}</label>
                  <div class="custom-file">
                    <input id="image" type="file" class="custom-file-input" name="image"
                      :class="{ 'is-invalid': form.errors.has('image') }" @change="onFileChange" />
                    <label class="custom-file-label" for="image">{{
                      $t('common.choose_file')
                    }}</label>
                  </div>
                  <has-error :form="form" field="image" />
                  <div class="bg-light mt-4 w-25">
                    <img v-if="url" :src="url" class="img-fluid" :alt="$t('common.image_alt')" />
                  </div>
                </div>

                <div class="form-group col-md-6 col-xl-4">
                  
                    <label for="customSpec" >{{
                      $t('common.customSpec')
                    }}</label>
                    <input v-model="form.customSpec" type="text" class="form-control"
                      :class="{ 'is-invalid': form.errors.has('customSpec') }" name="customSpec"
                      :placeholder="$t('common.customSpec_placeholder')" aria-label="customSpec"
                      aria-describedby="basic-addon1" />
                    
                    <has-error :form="form" field="customSpec" />
              
                </div>
              </div>

              
              
            </div>
            <div class="card-footer">
              <v-button :loading="form.busy" class="btn btn-primary">
                <i class="fas fa-save" /> {{ $t('common.save') }}
              </v-button>
              <button type="reset" class="btn btn-secondary float-right" @click="form.reset()">
                <i class="fas fa-power-off" /> {{ $t('common.reset') }}
              </button>
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
import { mapGetters } from 'vuex'

export default {
  middleware: ['auth', 'check-permissions'],
  metaInfo() {
    return { title: this.$t('products.list.create.page_title') }
  },
  data: () => ({
    breadcrumbsCurrent: 'products.list.create.breadcrumbs_current',
    breadcrumbs: [
      {
        name: 'products.list.create.breadcrumbs_first',
        url: 'home',
      },
      {
        name: 'products.list.create.breadcrumbs_second',
        url: 'products.index',
      },
      {
        name: 'products.list.create.breadcrumbs_active',
        url: '',
      },
    ],
    form: new Form({
      itemName: '',
      itemCode: '',
      itemModel: '',
      barcodeSymbology: 'CODE128',
      subCategory: '',
      brand: '',
      itemUnit: '',
      productTax: '',
      taxType: 'Exclusive',
      regularPrice: '',
      discount: '',
      sellingPrice: '',
      note: '',
      alertQuantity: 1,
      status: 1,
      image: '',
      customSpec: '',
    }),
    options: [],
    units: [],
    brands: [],
    taxes: [],
    prefix: '',
    url: null,
  }),
  computed: {
    ...mapGetters('operations', ['items', 'appInfo']),
  },
  created() {
    this.getSubCategories()
    this.getUnits()
    this.getBrands()
    this.getTaxes()
    this.getItemCode()
  },
  methods: {
    // get all product categories
    async getSubCategories() {
      await this.$store.dispatch('operations/allData', {
        path: '/api/all-product-sub-categories',
      })
    },

    // get all brands
    async getBrands() {
      const { data } = await axios.get(
        window.location.origin + '/api/all-brands'
      )
      this.brands = data.data
    },

    // get all units
    async getUnits() {
      const { data } = await axios.get(
        window.location.origin + '/api/all-units'
      )
      this.units = data.data
    },

    // get all taxes
    async getTaxes() {
      const { data } = await axios.get(
        window.location.origin + '/api/all-vat-rates'
      )
      this.taxes = data.data
      // assign default vat rate
      if (this.taxes && this.taxes.length > 0) {
        let defaultVatRateSlug = this.appInfo.defaultVatRateSlug;
        this.form.productTax = this.taxes.find(
          tax => tax.slug === defaultVatRateSlug
        )
      }
      this.calculatePrice()
    },

    // get item code
    async getItemCode() {
      const { data } = await axios.get(
        window.location.origin + '/api/generate-itemcode'
      )
      this.form.itemCode = data.code
      this.prefix = data.prefix
    },

    // calculate selling price
    calculatePrice() {
      if (this.form.sellingPrice && this.form.productTax && this.form.taxType) {
        let discount = 0
        if (this.form.discount && this.form.discount > 0) {
          discount = (this.form.discount / 100) * this.form.regularPrice
        }
        let currentPrice = this.form.regularPrice - discount

        let taxAmount = 0
        let totalTax = 0
        if (this.form.productTax.rate > 0) {
          taxAmount = this.form.productTax.rate / 100
        }
        if (this.form.taxType == 'Exclusive') {
          totalTax = currentPrice * taxAmount
        } else {
          totalTax = currentPrice - currentPrice / (1 + taxAmount)
        }

        if (this.form.taxType == 'Exclusive') {
          this.form.sellingPrice = this.form.regularPrice - discount + totalTax
        } else {
          this.form.sellingPrice =
            (this.form.regularPrice - discount) / (1 + taxAmount) + totalTax
        }
        return
      }
      return (this.form.sellingPrice = this.form.regularPrice)
    },

    // vue file upload
    onFileChange(e) {
      const file = e.target.files[0]
      const reader = new FileReader()
      if (
        file.size < 2111775 &&
        (file.type === 'image/jpeg' ||
          file.type === 'image/png' ||
          file.type === 'image/gif')
      ) {
        reader.onloadend = () => {
          this.form.image = reader.result
        }
        reader.readAsDataURL(file)
        this.url = URL.createObjectURL(file)
      } else {
        Swal.fire(
          this.$t('common.error'),
          this.$t('common.image_error'),
          'error'
        )
      }
    },

    // save product
    async saveProduct() {
      await this.form
        .post(window.location.origin + '/api/products')
        .then(() => {
          toast.fire({
            type: 'success',
            title: this.$t('products.list.create.success_msg'),
          })
          this.$router.push({ name: 'products.index' })
        })
        .catch(() => {
          toast.fire({ type: 'error', title: this.$t('common.error_msg') })
        })
    },
  },
}
</script>
