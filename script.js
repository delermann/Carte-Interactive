let map;
let allMarkers = [];

function initMap(lieuxData) {
    // Initialisation
    map = L.map('map', { zoomControl: false }).setView([47.746, 7.338], 14);
    
    L.control.zoom({ position: 'topright' }).addTo(map);

    L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Ajout des marqueurs
    lieuxData.forEach(l => {
        if (l.latitude && l.longitude) {
            const iconPath = l.icone_custom || 'https://cdn-icons-png.flaticon.com/512/1243/1243420.png';
            const customIcon = L.divIcon({
                className: 'none',
                html: `<div class="pin-wrapper"><img src="${iconPath}"></div>`,
                iconSize: [32, 32], iconAnchor: [16, 36], popupAnchor: [0, -32]
            });

            const marker = L.marker([l.latitude, l.longitude], { icon: customIcon });
            
            let popupHTML = `
                <div class="popup-card">
                    <small style="text-transform:uppercase; font-weight:800; color:var(--active-green); font-size:0.55rem;">${l.cat_nom || ''}</small>
                    <h3>${l.nom}</h3>
                    ${l.image_url ? `<img src="${l.image_url}">` : ''}
                    <p>${l.description || ''}</p>`;
            
            if (l.podcast_url && l.podcast_url.trim() !== "") {
                popupHTML += `
                    <a href="${l.podcast_url}" target="_blank" class="btn-podcast">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"></path><path d="M19 10v2a7 7 0 0 1-14 0v-2"></path><line x1="12" y1="19" x2="12" y2="23"></line><line x1="8" y1="23" x2="16" y2="23"></line></svg>
                        ÉCOUTER LE PODCAST
                    </a>`;
            }

            if (l.site_web && l.site_web.trim() !== "") {
                popupHTML += `<a href="${l.site_web}" target="_blank" class="btn-web">CONSULTER LE SITE</a>`;
            }

            popupHTML += `</div>`;
            
            marker.bindPopup(popupHTML);
            marker.categorieId = l.categorie_id;
            marker.addTo(map);
            allMarkers.push(marker);
        }
    });
}

function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const btn = document.getElementById('menu-toggle');
    sidebar.classList.toggle('hidden');
    btn.classList.toggle('open');
    setTimeout(() => { if(map) map.invalidateSize(); }, 400);
}

function filterMarkers(catId, btn) {
    document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    
    allMarkers.forEach(marker => {
        if (catId === 'all' || marker.categorieId == catId) {
            map.addLayer(marker);
        } else {
            map.removeLayer(marker);
        }
    });
    
    if (window.innerWidth < 768) toggleSidebar();
}