import { BusinessPromotion } from '@/types';

type Coordinates = { lat: number; lng: number };
type OnDragEndCallback = (coords: Coordinates) => void;

export function useMap() {
    let map: any = null;
    let markers: any = null;

    const initMap = (lat: number, lon: number, containerId: string = 'map') => {
        map = L.map(containerId, {
            worldCopyJump: true,
            zoomAnimation: true,
            minZoom: 6,
            maxZoom: 18,
        }).setView([lat, lon], 11);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
        }).addTo(map);

        markers = L.featureGroup().addTo(map);
    };

    const addDraggableMarker = (lat: number, lon: number, onDragEndCallback: OnDragEndCallback) => {
        if (!map) return;

        L.marker([lat, lon], { draggable: true })
            .addTo(map)
            .on('dragend', (e: any) => {
                const newCoords = e.target.getLatLng();
                onDragEndCallback({ lat: newCoords.lat, lng: newCoords.lng });
            });
    };

    const addMarkersWithPromotions = (businesses: BusinessPromotion[]) => {
        if (!markers) return;

        const myIcon = L.icon({
            iconUrl: '/icon-promotion.svg',
            iconSize: [25, 25],
        });

        businesses.forEach((b) => {
            L.marker([b.latitude, b.longitude], {
                title: b.promotion.title,
                icon: myIcon,
            }).addTo(markers).bindPopup(`
            <div class="max-w-[250px] text-sm text-[#1b1b18]">
                <img 
                src="${b.promotion.image}" 
                alt="Imagen de promoción" 
                class="w-full h-32 object-cover rounded-md mb-2"
                />
                <span class="inline-block rounded-full bg-[#e0e0e0] px-3 py-0.5 text-xs font-medium text-[#1b1b18]">${b.promotion.category}</span>
                <h3 class="font-semibold text-base">${b.promotion.title}</h3>
                <p class="text-xs text-gray-700">${b.promotion.description}</p>
            </div>
            `);
        });
    };

    return {
        initMap,
        addDraggableMarker,
        addMarkersWithPromotions,
    };
}
