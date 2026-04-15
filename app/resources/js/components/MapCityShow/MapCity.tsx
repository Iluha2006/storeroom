// components/CellMap.tsx
import React from 'react';
// eslint-disable-next-line import/order
import { MapContainer, TileLayer } from 'react-leaflet';

// eslint-disable-next-line import/order
import L from 'leaflet';

import { ICell } from '@/types/Cell';

import CityMarker from './CityMarker';

// Исправляем иконки маркеров
L.Icon.Default.mergeOptions({
  iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon-2x.png',
  iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
});



interface CellMapProps {
  cell: ICell;
}

const CellMap: React.FC<CellMapProps> = ({ cell }) => {


    const hasCoordinates =
    (cell.object?.address?.coordinates.lat && cell.object?.address?.coordinates.lon);

  if (!hasCoordinates) {
    return (
      <div className="h-64 flex items-center justify-center bg-gray-50 rounded-lg border">
        <p className="text-gray-500">Нет координат для отображения на карте</p>
      </div>
    );
  }



  const position : [number, number] = [cell.object!.address!.coordinates.lon!, cell.object!.address!.coordinates.lat!];

  return (
    <div className="h-96 w-full rounded-lg overflow-hidden border">
      <MapContainer
        center={position}
        zoom={15}
        className="h-full w-full"
        scrollWheelZoom={true}
      >
        <TileLayer
          url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
        />

           <CityMarker cell={cell} citySlug={cell.object?.address?.city?.name} />
      </MapContainer>
    </div>
  );
};

export default CellMap;
