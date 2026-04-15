// MapCityPosition.tsx
// eslint-disable-next-line import/order
import { MapContainer, TileLayer } from 'react-leaflet';
import 'leaflet/dist/leaflet.css';


// eslint-disable-next-line import/order
import { Icon } from 'leaflet';

// eslint-disable-next-line @typescript-eslint/no-explicit-any
delete (Icon.Default.prototype as any)._getIconUrl;

Icon.Default.mergeOptions({
  iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon-2x.png',
  iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
});

import { ICell } from '@/types/Cell';

import { useMapCells } from '../../hooks/useCityMap';

import CityMarker from './CityMarker';

interface MapCityPositionProps {
  cells: ICell[];
}

const MapCityPosition: React.FC<MapCityPositionProps> = ({ cells }) => {
  const { center, zoom, cellsWithCoords } = useMapCells(cells);

  if (cellsWithCoords.length === 0) {
    return (
      <div className="h-[500px] w-full max-w-6xl mx-auto rounded-lg overflow-hidden shadow-md border flex items-center justify-center bg-gray-50">
        <div className="text-center text-gray-500">
          <h3 className="text-lg font-semibold mb-2">Нет данных для карты</h3>
          <p className="text-sm">У ячеек нет координат</p>
        </div>
      </div>
    );
  }

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
        {cellsWithCoords.map((cell: ICell) => (
          <CityMarker key={cell.uuid} cell={cell} />
        ))}
      </MapContainer>
    </div>
  );
};

export default MapCityPosition;