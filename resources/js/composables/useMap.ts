interface Promotion {
    title: string;
}

interface Business {
    latitude: number;
    longitude: number;
    promotion: Promotion;
}

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
        }).setView([lat, lon], 14);

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

    const addMarkersWithPromotions = (businesses: Business[]) => {
        if (!markers) return;

        const myIcon = L.icon({
            iconUrl: '/icon-promotion.svg',
            iconSize: [25, 25],
        });

        businesses.forEach((business) => {
            L.marker([business.latitude, business.longitude], {
                title: business.promotion.title,
                icon: myIcon,
            })
                .addTo(markers)
                .bindPopup(business.promotion.title);
        });
    };

    return {
        initMap,
        addDraggableMarker,
        addMarkersWithPromotions,
    };
}
