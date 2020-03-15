<template>
<div>
    <div v-if="loading&&!status">
        <p>Loading.................</p>
    </div>
    <div v-else-if="status" class="main-card mb-3 card">
        <div class="card-header">
            <vac :end-time="new Date().getTime() + time" @finish="(vac) => finish(vac)">
            <template
                v-slot:process="{ timeObj }">
                <span>{{ `QRcode ${timeObj.m}:${timeObj.s}` }}</span>
            </template>
            <template
                v-slot:finish>
                <span>Done!</span>
            </template>
            </vac>
            <div class="btn-actions-pane-right">

            </div>
        </div>
        <div class="card-body">
            <div class="visible-print text-center">
                <qrshow v-if="lokasi&&status" :value="qr" :version=1 :scale=4 :maskPattern=0 errorCorrectionLevel="high"></qrshow>

                <p v-else>Silahkan Aktifkan GPS pada perangkat terlebih dahulu</p>
            </div>
        </div>
    </div>
    <div v-else class="main-card mb-3 card">
        <div class="card-header">Konfirmasi
            <div class="btn-actions-pane-right">

            </div>
        </div>
        <div class="card-body">
            QRCode akan tampil dan aktif hanya 30 menit dan tidak bisa diulang, jadi pastikan karyawan sudah lengkap berada di hadapan anda
            lalu tekan tombol mulai untuk mengaktifkan QRCode
            <br>
            <div><button @click="activeQRCode" class="btn btn-success">Mulai</button></div>
        </div>
    </div>


</div>
</template>

<script>
import qrshow from 'vue-qrcode';
import axios from 'axios';
import { mapState,mapActions } from 'vuex'

export default {
    data: function() {
        return {
            qr: 'BMT00384',
            show:true,
            loading: true,
        }
    },
    components:{qrshow},
    mounted(){
        window.Echo.channel("newScanValid").listen(".scan-valid", e => {
          this.$store.dispatch('showqr/newQRCode', e.data)
        });
        this.$store.dispatch('showqr/getQRCode',window.location.pathname)
        this.$store.dispatch('showqr/getLocation')
    },
    computed: mapState({
        qrcode: state => state.showqr.qrcode,
        time:state => state.showqr.time,
        size:state => state.showqr.size,
        lokasi:state => state.showqr.lokasi,
        status:state => state.showqr.status,

    }),
    created(){
        //this.fetchData()
    },
    methods: {
        ...mapActions('showqr', [
        'activeQRCode'
        ]),
        tes(){
            console.log(this.$state.finish)
        },
        finish(vac) {
        console.log(vac.state.finish)
        }
    },
    // methods:{
    //     mulai(){

    //     }
    //     // fetchData(){
    //     //     var v = this;
    //     //     this.gettingLocation = true;
    //     //     // get position
    //     //     navigator.geolocation.getCurrentPosition(pos => {
    //     //     this.gettingLocation = false;
    //     //     this.location = pos;
    //     //     this.lokasi = true;
    //     //     }, err => {
    //     //     this.gettingLocation = false;
    //     //     this.errorStr = err.message;
    //     //     })
    //     //     setTimeout(function () {
    //     //         axios
    //     //         .post('/api/qrcode-link',{latitude:v.location.coords.latitude, longitude:v.location.coords.longitude, link:v.link})
    //     //         .then(response => {
    //     //             v.qr = response.data.qrcode;
    //     //             this.lokasi = false;
    //     //         });
    //     //         v.fetchData();
    //     //     },2000);
    //     // }
    // },

}
</script>

<style>


</style>
