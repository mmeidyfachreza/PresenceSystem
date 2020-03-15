<template>
  <div>
    <p class="error">{{ error }}</p>

    <div>
        <transition name="fade">
        <p v-if="show&&lokasi">
            <!-- <qrcode-stream @decode="onDecode" @init="onInit" /> -->
            <StreamBarcodeReader @decode="onDecode"></StreamBarcodeReader>
        </p>
        </transition>
    </div>

    <p>Status Presensi :</p>
    <div v-if="status">
        <div class="alert alert-success">
            <p>Presensi Tervalidasi Silahkan Kembali ke halaman presensi</p>
        </div>
    </div>
    <div v-else>
        <div class="alert alert-danger">
            <p>{{pesan}}</p>
        </div>
    </div>
    <p v-if="loading">Silahkan lakukan scanning dan Jika tampilan scanner tidak muncul silahkan aktifkan GPS terlebih dahulu lalu refresh halaman ini</p>

  </div>
</template>

<script>
// import { QrcodeStream } from 'vue-qrcode-reader'
import { StreamBarcodeReader } from "vue-barcode-reader";

export default {
    props:['user'],
//   components: { QrcodeStream },
components: { StreamBarcodeReader },
  data () {
    return {
      result: '',
      status: '',
      error: '',
      pesan: 'gagal',
      loading: true,
      location:null,
      gettingLocation: false,
      errorStr:null,
      show: true,
      lokasi: false,
      ada: false,
    }
  },

  methods: {
    onDecode (result) {
      this.result = result;

      axios
        .post('/api/qrcode',{
            qrcode: this.result,
            user: this.user,
            latitude: this.location.coords.latitude,
            longitude: this.location.coords.longitude,
            })
        .then(response => {
            this.status = response.data.hasil
            this.show = !response.data.hasil
            this.loading = false
            this.pesan = response.data.pesan
            console.log(response)
            // v.qr = response.data.data[0].qrcode;
        });
    },

    async onInit (promise) {
      try {
        await promise
      } catch (error) {
        if (error.name === 'NotAllowedError') {
          this.error = "ERROR: you need to grant camera access permisson"
        } else if (error.name === 'NotFoundError') {
          this.error = "ERROR: no camera on this device"
        } else if (error.name === 'NotSupportedError') {
          this.error = "ERROR: secure context required (HTTPS, localhost)"
        } else if (error.name === 'NotReadableError') {
          this.error = "ERROR: is the camera already in use?"
        } else if (error.name === 'OverconstrainedError') {
          this.error = "ERROR: installed cameras are not suitable"
        } else if (error.name === 'StreamApiNotSupportedError') {
          this.error = "ERROR: Stream API is not supported in this browser"
        }
      }
    },

    sendData(){
        axios
            .post('qrcode',this.result)
            .then(response => {
                console.log(response);
                // v.qr = response.data.data[0].qrcode;
            });
    },
    geo(){
    let v = this
        //do we support geolocation
    if(!("geolocation" in navigator)) {
      this.errorStr = 'Geolocation is not available.';
      return;
    }

    this.gettingLocation = true;
    // get position
    navigator.geolocation.getCurrentPosition(pos => {
      this.gettingLocation = false;
      this.location = pos;
      this.lokasi = true;
    }, err => {
      this.gettingLocation = false;
      this.errorStr = err.message;
    })
        setTimeout(function () {
           v.geo();
        },3000);
    }
  },
  created() {
    this.geo()
  },

}
</script>

<style scoped>

</style>
