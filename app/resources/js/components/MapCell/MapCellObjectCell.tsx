import L from 'leaflet';
import { useMemo } from "react";
import { MapContainer, TileLayer } from 'react-leaflet';

import { filterCellsWithCoordinates } from "../../utils/filterCells";

import MapMarker from './MapMarker';

import 'leaflet/dist/leaflet.css';
// eslint-disable-next-line import/order
import { ICell } from '@/types/Cell';



L.Icon.Default.mergeOptions({
  iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon-2x.png',
  iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
});

interface MapCellObjectCellProps {
  cells: ICell[];
}

export default function MapCellObjectCell({ cells }: MapCellObjectCellProps) {
  const MapCoordinates = useMemo(() => {
    return filterCellsWithCoordinates(cells);
  }, [cells]);


  if (MapCoordinates.length === 0) {
    return (
      <div className="h-[500px] flex items-center justify-center bg-gray-50 border rounded-lg">
        Нет данных для отображения на карте
      </div>
    );
  }

  const first = MapCoordinates[0];
  const center: [number, number] = [
    first.object!.address!.coordinates.lat,
    first.object!.address!.coordinates.lon
  ];
  const zoom = MapCoordinates.length === 1 ? 15 : 14;

  return (
    <div className="h-[500px] w-full max-w-6xl mx-auto rounded-lg overflow-hidden shadow-md border">
      <MapContainer
        center={center}
        zoom={zoom}
        className="h-full w-full"
        scrollWheelZoom={true}
        style={{ background: '#f8f9fa' }}
        attributionControl={false}
      >
        <TileLayer
          url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
          attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        />
        {MapCoordinates.map((cell) => (
          <MapMarker key={cell.uuid} cell={cell} />
        ))}
      </MapContainer>
    </div>
  );
}
