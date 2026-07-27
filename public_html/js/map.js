 var md = new MobileDetect(window.navigator.userAgent);
 if (md.mobile() != null) {

    var marker;
    
    var thisMaps     = L.map('appCapsule',{fullscreenControl: { pseudoFullscreen: false }}).setView([-0.4790387,117.1390816], 11);
    var tiles = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(thisMaps);

    $.ajax({
        url  : '?geojson=polygon',
        success: function(data) {
            kelurahan(data); 
        },
        error: function() {
            alert('Error occured');
        }
    });


    var color_scale = chroma.scale(['yellow','green','red','black']);
    // get color depending on population density value
    function getColor(d,e) {
        if(d == 0)
        {
            return '#B73E3E';
        }else{
            return color_scale(d/e).hex() 
        }
    }

    function yourlocation(){

       function onLocationFound(e) {
         
        var radius = e.accuracy / 5;
        
        // var circle = L.circle(e.latlng, radius).addTo(thisMaps);
        
        marker = L.marker(e.latlng)
        .addTo(thisMaps)
        .bindPopup("Anda berada di dalam " + radius.toFixed(1) + " meter dari titik ini")
        .openPopup();
    }

    function onLocationError(e) {
        alert(e.message);
    }

    thisMaps.on("locationfound", onLocationFound);
    thisMaps.on("locationerror", onLocationError);
    thisMaps.locate({ setView: !0, maxZoom: 19 });

}


function kelurahan(data)
{
    $.each(data, function(key,item) {
        var area = JSON.parse(item.area);
        var dc = getColor(key,data.length);
        var geojson = new L.geoJson(area,{
            style: {
              "color": dc,
              "weight": 4,
              "opacity": 1,
              "fillOpacity": 0
          },
          onEachFeature: function (feature, layer) {
            layer.on('mouseover', function (e) {
                this.openPopup();
            });
            layer.on('mouseout', function (e) {
                this.closePopup();
            });
            layer.on('click', function(e) {
             $('.modal-title').html(`Kelurahan ${item.nama}`);
             
             var info = `<div class="alert alert-primary mb-2" role="alert">
                 Anda mengunjungi <b>Kelurahan ${item.nama}</b> yang berada di dalam <b>Kecamatan ${item.kecamatan.nama}</b> berikut ini informasi yang anda dapat peroleh :
             </div>`;

             var seg0 =`<div class="section p-0 mb-2">
                <div class="card shadow-none">
                    <div class="profile-head">
                        <div class="avatar">
                            <img src="${item.kecamatan.foto_camat}" alt="${item.kecamatan.camat}" class="imaged bg-white w140">
                        </div>
                        <div class="in">
                            <h4 class="name">${item.kecamatan.camat}</h4>
                            <h5 class="subtext">Camat ${item.kecamatan.nama}</h5>
                            <h6 class="mt-1">${item.kecamatan.alamat}</h6>
                        </div>
                    </div>
                </div>
            </div>`;

            var seg1 =`<div class="section p-0 mb-2">
                <div class="row">
                    <div class="col-3">
                        <a href="mailto:${item.kecamatan.email}" class="card shadow-none">
                            <img src="https://img.icons8.com/plasticine/344/apple-mail.png" class="img-fluid" alt="image">
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="tel:${item.kecamatan.telepon}" class="card shadow-none">
                            <img src="https://img.icons8.com/plasticine/344/apple-phone.png" class="img-fluid" alt="image">
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="https://maps.google.com/?q=${item.kecamatan.latitude},${item.kecamatan.longitude}" class="card shadow-none">
                            <img src="https://img.icons8.com/plasticine/344/apple-map.png" class="img-fluid" alt="image">
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="${item.kecamatan.website}" class="card shadow-none">
                            <img src="https://img.icons8.com/plasticine/344/safari.png" class="img-fluid" alt="image">
                        </a>
                    </div>
                </div>
            </div>`;


            var seg2 =`<div class="section p-0 mt-4 mb-2">
                <div class="card shadow-none">
                    <div class="profile-head">
                        <div class="avatar">
                            <img src="${item.kelurahan.foto_lurah}" alt="${item.kelurahan.lurah}" class="imaged bg-dark w140">
                        </div>
                        <div class="in">
                            <h4 class="name">${item.kelurahan.lurah}</h4>
                            <h5 class="subtext">Lurah ${item.nama}</h5>
                            <h6 class="mt-1">${item.kelurahan.alamat}</h6>
                        </div>
                    </div>
                </div>
            </div>`;


            var seg3 =`<div class="section p-0 mb-2">
                <div class="row">
                    <div class="col-3">
                        <a href="mailto:${item.kelurahan.email}" class="card shadow-none">
                            <img src="https://img.icons8.com/plasticine/344/apple-mail.png" class="img-fluid" alt="image">
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="tel:${item.kelurahan.telepon}" class="card shadow-none">
                            <img src="https://img.icons8.com/plasticine/344/apple-phone.png" class="img-fluid" alt="image">
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="https://maps.google.com/?q=${item.kelurahan.latitude},${item.kelurahan.longitude}" class="card shadow-none">
                            <img src="https://img.icons8.com/plasticine/344/apple-map.png" class="img-fluid" alt="image">
                        </a>
                    </div>
                    <div class="col-3">
                        <a href="${item.kelurahan.website}" class="card shadow-none">
                            <img src="https://img.icons8.com/plasticine/344/safari.png" class="img-fluid" alt="image">
                        </a>
                    </div>
                </div>
            </div>`;


            $('.modal-body').html(`${info} ${seg0} ${seg1}<hr>${seg2} ${seg3}`);

            $('.map-modal').modal('show');
        });
    }});

    
    geojson._leaflet_id = item.uuid;
    thisMaps.addLayer(geojson);
    geojson._leaflet_id = item.uuid;
    
});

yourlocation();

}

$('.leaflet-control-attribution').hide();



$("#pusatkan").click(function () {
    thisMaps.flyTo(new L.LatLng(-0.503847, 117.156984), 11);
});
}else{
    $('#appCapsule').html(`<div class="error-page">
        <img src="/blockmaps.svg" alt="alt" class="imaged square w800">
        <h1 class="title">Terjadi Masalah !</h1>
        <div class="text mb-5">
            Fitur ini hanya kami tujukan kepada pengguna mobile.
        </div>
    </div>`);   
}