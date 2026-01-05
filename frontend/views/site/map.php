<?php

use yii\helpers\Json;

$this->title = 'iGOV';

$points = [];

foreach ($locations as $post) {
    if (empty($post->address_coords)) {
        continue;
    }

    [$lat, $lng] = array_map('trim', explode(',', $post->address_coords));

    if (!is_numeric($lat) || !is_numeric($lng)) {
        continue;
    }

    $points[] = [
        'lat' => (float)$lat,
        'lng' => (float)$lng,
        'image' => $post->img_path ?? '', // store image URL
        'id' => $post->id,
    ];
}

?>

<div id="map" style="width:100%; height:100vh;"></div>

<script>
    const locations = <?= Json::encode($points) ?>;

    const map = L.map('map').setView([42.8746, 74.5698], 12); // default center

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(map);

    const bounds = [];

    locations.forEach(loc => {
        let popupContent = '';
        if (loc.image) {
            popupContent = `<a href="/post/view?id=${loc.id}" target="_blank">
                    <img src="${loc.image}" style="width:120px; height:auto; border-radius:8px;">
                </a>`;

        } else if (loc.title) {
            popupContent = loc.title; // fallback text
        }

        const marker = L.marker([loc.lat, loc.lng])
            .addTo(map)
            .bindPopup(popupContent);
        bounds.push([loc.lat, loc.lng]);
    });

    if (bounds.length) {
        map.fitBounds(bounds, {
            padding: [50, 50]
        });
    }
</script>