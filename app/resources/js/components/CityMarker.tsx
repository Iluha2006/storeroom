// components/CityMarker.tsx
import React, { useCallback } from 'react';
import { Marker, Popup } from 'react-leaflet';
import { Link } from 'react-router-dom';

import { ICell } from '@/types/Cell';

interface CityMarkerProps {
  cell: ICell;
  onClick?: (cell: ICell) => void;
  citySlug?: string;
}

const CityMarker: React.FC<CityMarkerProps> = ({
  cell,
  onClick,
  citySlug
}) => {
  const handleClick = useCallback(() => {
    if (onClick) {
      onClick(cell);
    }
  }, [onClick, cell]);


  const hasCoordinates = cell.object?.address?.lat && cell.object?.address?.lon;

  if (!hasCoordinates) {
    console.warn(`Cell ${cell.slug} has no coordinates`);
    return null;
  }

  const position: [number, number] =  [cell.object!.address!.lat!, cell.object!.address!.lon!];

  return (
    <Marker
      position={position}
      eventHandlers={{ click: handleClick }}
    >
      <Popup>
        <div className="p-3 min-w-[250px] max-w-[300px]">
          <h3 className="font-bold text-lg mb-2 text-gray-800">{cell.object?.name}</h3>

          <div className="space-y-2 mb-3">
            {cell.object?.address?.full_address && (
              <p className="text-sm text-gray-600">
                📍 {cell.object.address.full_address}
              </p>
            )}

            {cell.object?.organization?.phone && (
              <p className="text-sm text-gray-600">
                📞 {cell.object.organization.phone}
              </p>
            )}

            {cell.price && (
              <p className="text-sm text-gray-600">
                💰 Цена: {Number(cell.price.amount).toLocaleString('ru-RU')} ₽
              </p>
            )}
          </div>

          <div className="border-t pt-3">
            {citySlug ? (
              <Link
                to={`/cellObject/${cell.slug}`}
                className="block w-full text-center px-4 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 transition-colors text-sm font-medium"
              >
                Выбрать ячейку
              </Link>
            ) : (
              <button
                className="w-full px-4 py-2 bg-emerald-500 text-white rounded-md hover:bg-emerald-600 transition-colors text-sm font-medium"
                onClick={handleClick}
              >
                Выбрать ячейку
              </button>
            )}
          </div>
        </div>
      </Popup>
    </Marker>
  );
};

export default CityMarker;