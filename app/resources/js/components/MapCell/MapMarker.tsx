
import { Icon } from 'leaflet';
import React, { useCallback } from 'react';
import { Marker, Popup } from 'react-leaflet';
import { useNavigate } from 'react-router-dom';

// eslint-disable-next-line import/order
import { ICell } from '@/types/Cell';


import 'leaflet/dist/leaflet.css';
import CellActionButtons from '@/UI/Button/Cell/CellAction';

interface MapMarkerProps {
  cell: ICell;
  isSelected?: boolean;
  onSelect?: (cell: ICell) => void;
}

const defaultIcon = new Icon({
  iconUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon.png',
  iconRetinaUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-icon-2x.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});

const selectedIcon = new Icon({
  iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
  iconRetinaUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-green.png',
  shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.7.1/images/marker-shadow.png',
  iconSize: [25, 41],
  iconAnchor: [12, 41],
  popupAnchor: [1, -34],
  shadowSize: [41, 41]
});

const MapMarker: React.FC<MapMarkerProps> = ({ cell, isSelected = false, onSelect }) => {
  const navigate = useNavigate();

  const handleMarkerClick = useCallback(() => {
    onSelect?.(cell);
  }, [cell, onSelect]);

  const handleDetailsClick = () => {
    navigate(`/cellObject/${cell.slug}`);
  };


  const lat = cell.object?.address?.coordinates?.lat;
  const lon = cell.object?.address?.coordinates?.lon;

  if (!lat || !lon) {
    return null;
  }

  const position: [number, number] = [lat, lon];

  return (
    <Marker
      position={position}
      icon={isSelected ? selectedIcon : defaultIcon}
      eventHandlers={{ click: handleMarkerClick }}
    >
      <Popup className="custom-popup">
        <div className="p-3 min-w-[250px] max-w-[280px]">

          <div className="mb-3">
            <h3 className="font-bold text-lg text-gray-800 mb-1">

              { cell.object.address.city?.name}

            </h3>
            {isSelected && (
              <span className="inline-block px-2 py-1 bg-emerald-100 text-emerald-800 text-xs font-medium rounded">
                Выбрана
              </span>
            )}
          </div>


          <div className="space-y-2 mb-4">

            {cell.object?.address?.full_address && (
              <div>
                <span className="text-sm font-medium text-gray-700">Адрес:</span>
                <span className="text-sm text-gray-600">{cell.object.address.full_address}</span>
              </div>
            )}

{(cell.price?.amount || cell.object?.organization?.phone) && (
  <div className="flex flex-wrap items-center gap-4">
    {cell.price?.amount && (
      <div className="flex items-baseline gap-1">
        <span className="text-sm font-medium text-gray-700">Цена:</span>
        <span className="text-lg font-bold text-emerald-600">
          {Number(cell.price.amount).toLocaleString('ru-RU')} ₽/мес
        </span>
      </div>
    )}

    {cell.object?.organization?.phone && (
      <div className="flex items-baseline gap-1">
        <span className="text-sm font-medium text-gray-700">Телефон:</span>
        <a
          href={`tel:${cell.object.organization.phone}`}
          className="text-sm text-emerald-600 hover:text-emerald-800 font-medium"
        >
          {cell.object.organization.phone}
        </a>
      </div>
    )}
  </div>
)}
          </div>

          <div className="space-y-2">
          <CellActionButtons
          onDetailsClick={handleDetailsClick}
          />
          </div>
        </div>
      </Popup>
    </Marker>
  );
};

export default MapMarker;
