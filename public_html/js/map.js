(function() {
    var md = new MobileDetect(window.navigator.userAgent);
    if (md.mobile() != null) {

        var marker;
        var container = document.getElementById('map-container');
        if (!container) return;

        var thisMaps = L.map(container, {fullscreenControl: { pseudoFullscreen: false }}).setView([-0.4790387,117.1390816], 11);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(thisMaps);

        fetch('?geojson=polygon')
            .then(function(r) { return r.json(); })
            .then(function(data) { kelurahan(data); })
            .catch(function() { alert('Error occured'); });

        var color_scale = chroma.scale(['yellow','green','red','black']);

        function getColor(d,e) {
            if (d == 0) return '#B73E3E';
            return color_scale(d/e).hex();
        }

        function yourlocation() {
            function onLocationFound(e) {
                var radius = e.accuracy / 5;
                marker = L.marker(e.latlng)
                    .addTo(thisMaps)
                    .bindPopup("Anda berada di dalam " + radius.toFixed(1) + " meter dari titik ini")
                    .openPopup();
            }
            function onLocationError(e) { alert(e.message); }
            thisMaps.on("locationfound", onLocationFound);
            thisMaps.on("locationerror", onLocationError);
            thisMaps.locate({ setView: !0, maxZoom: 19 });
        }

        function kelurahan(data) {
            data.forEach(function(item) {
                var area = JSON.parse(item.area);
                var dc = getColor(item.value, data.length);
                var geojson = L.geoJson(area, {
                    style: {
                        color: dc,
                        weight: 4,
                        opacity: 1,
                        fillOpacity: 0
                    },
                    onEachFeature: function(feature, layer) {
                        layer.on('mouseover', function(e) { this.openPopup(); });
                        layer.on('mouseout', function(e) { this.closePopup(); });
                        layer.on('click', function(e) {
                            var dialog = document.getElementById('map-dialog');
                            if (!dialog) return;
                            dialog.querySelector('.md-title').textContent = 'Kelurahan ' + item.nama;

                            var info = '<div style="background:var(--jp-surface-2);padding:12px;border-radius:8px;margin-bottom:12px;font-size:.85rem">Anda mengunjungi <b>Kelurahan ' + item.nama + '</b> yang berada di dalam <b>Kecamatan ' + item.kecamatan.nama + '</b> berikut ini informasi yang anda dapat peroleh :</div>';

                            var seg0 = '<div class="u-flex u-flex-col u-align-center u-text-center u-mb-md">' +
                                '<img src="' + item.kecamatan.foto_camat + '" alt="' + item.kecamatan.camat + '" class="map-popup-avatar">' +
                                '<h4 class="map-popup-name">' + item.kecamatan.camat + '</h4>' +
                                '<p class="map-popup-sub">Camat ' + item.kecamatan.nama + '</p>' +
                                '<p class="map-popup-addr">' + item.kecamatan.alamat + '</p>' +
                                '<div class="map-popup-links">' +
                                '<a href="mailto:' + item.kecamatan.email + '">Email</a>' +
                                '<a href="tel:' + item.kecamatan.telepon + '">Telp</a>' +
                                '<a href="https://maps.google.com/?q=' + item.kecamatan.latitude + ',' + item.kecamatan.longitude + '">Maps</a>' +
                                '<a href="' + item.kecamatan.website + '">Website</a>' +
                                '</div></div>';

                            var seg2 = '<hr class="map-popup-divider">' +
                                '<div class="u-flex u-flex-col u-align-center u-text-center">' +
                                '<img src="' + item.kelurahan.foto_lurah + '" alt="' + item.kelurahan.lurah + '" class="map-popup-avatar">' +
                                '<h4 class="map-popup-name">' + item.kelurahan.lurah + '</h4>' +
                                '<p class="map-popup-sub">Lurah ' + item.nama + '</p>' +
                                '<p class="map-popup-addr">' + item.kelurahan.alamat + '</p>' +
                                '<div class="map-popup-links">' +
                                '<a href="mailto:' + item.kelurahan.email + '">Email</a>' +
                                '<a href="tel:' + item.kelurahan.telepon + '">Telp</a>' +
                                '<a href="https://maps.google.com/?q=' + item.kelurahan.latitude + ',' + item.kelurahan.longitude + '">Maps</a>' +
                                '<a href="' + item.kelurahan.website + '">Website</a>' +
                                '</div></div>';

                            dialog.querySelector('.md-body').innerHTML = info + seg0 + seg2;
                            dialog.showModal();
                        });
                    }
                });
                geojson._leaflet_id = item.uuid;
                thisMaps.addLayer(geojson);
                geojson._leaflet_id = item.uuid;
            });
            yourlocation();
        }

        document.querySelector('.leaflet-control-attribution')?.style.setProperty('display', 'none');

        var pusatkan = document.getElementById('pusatkan');
        if (pusatkan) {
            pusatkan.addEventListener('click', function() {
                thisMaps.flyTo(new L.LatLng(-0.503847, 117.156984), 11);
            });
        }
    } else {
        var container = document.getElementById('map-container');
        if (container) {
            container.innerHTML = '<div class="error-page" style="text-align:center;padding:60px 20px">' +
                '<img src="/blockmaps.svg" alt="blocked" style="max-width:400px;margin-bottom:24px">' +
                '<h1>Terjadi Masalah !</h1>' +
                '<p style="color:#8899aa">Fitur ini hanya kami tujukan kepada pengguna mobile.</p></div>';
        }
    }
})();
