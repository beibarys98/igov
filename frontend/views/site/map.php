<?php

use yii\helpers\Json;

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
        'title' => isset($post->desc) ? mb_substr($post->desc, 0, 16) : '',
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
        const marker = L.marker([loc.lat, loc.lng])
            .addTo(map)
            .bindPopup(loc.title);

        bounds.push([loc.lat, loc.lng]);
    });

    if (bounds.length) {
        map.fitBounds(bounds, {
            padding: [50, 50]
        });
    }
</script>