<template>
<div>
<table class="table info">
    <tbody>
        <tr>
            <td class="label">Waktu Hadir</td>
            <td>:</td>
            <td v-if="jam_hadir">{{jam_hadir}}</td>
            <td v-else></td>
        </tr>
        <tr>
            <td class="label">Waktu Pulang</td>
            <td>:</td>
            <td v-if="jam_pulang">{{jam_pulang}}</td>
            <td v-else></td>
        </tr>
        <tr>
            <td class="label">Durasi Kerja</td>
            <td>:</td>
            <td v-if="durasi">{{durasi}} jam</td>
            <td v-else></td>
        </tr>
    </tbody>
  </table>
  <div class="row">
      <a :href="linkV" v-if="!jam_hadir" class="col-lg-6 btn btn-info">Presensi Hadir</a>
      <a :href="linkV" v-if="!jam_pulang&&jam_hadir" class="col-lg-6 btn btn-success">Presensi Pulang {{jam_pulang}}</a>
      <p v-if="jam_pulang&&jam_hadir" class="px-4">Anda sudah melakukan presensi hari ini, selamat beristirahat</p>
  </div>
</div>
</template>

<script>
import axios from 'axios'
export default {
    props:['noid','data'],
    data () {
    return {
      result: '',
      status: '',
      durasi:'',
      jam_hadir:'',
      jam_pulang:'',
      error: '',
      validasi: '',
      lokasi: false,
      latitude: '',
      longitude: '',
      location:null,
      gettingLocation: false,
      errorStr:null,
      show: true,
      linkV:'/presensi/scanner',
      linkLoc:'',
    }
  },
    methods:{


    },
    created() {
        //this.setData()

        axios
            .get('/api/presensi/'+this.noid+'')
            .then(response => {
                console.log(response);
                this.jam_hadir = response.data.data.jam_hadir
                this.jam_pulang = response.data.data.jam_pulang
                this.durasi = response.data.data.durasi_kerja
                console.log(this.jam_hadir);
                //this.linkLoc ='https://www.google.com/maps/place/'+response.data.latitude+','+response.data.longitude
            });

  },

}
</script>

<style>
.info td.label{
    width: 40%;
}
</style>
