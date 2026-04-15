import { LatLngBounds, LatLng } from 'leaflet';
import { useMemo } from 'react';

import { ICell } from '@/types/Cell';

import { filterCellsWithCoordinates } from '../utils/filterCells';

export const useMapCells = (cells: ICell[]) => {
  const cellsWithCoords = useMemo(() => {
    return filterCellsWithCoordinates(cells);
  }, [cells]);

  const { center, zoom } = useMemo(() => {
    if (cellsWithCoords.length === 0) {
      return { center: [55.7558, 37.6173] as [number, number], zoom: 13 };
    }

    if (cellsWithCoords.length === 1) {
      const cell = cellsWithCoords[0];
      const lat = cell.object!.address!.coordinates.lat;
      const lon = cell.object!.address!.coordinates.lon;
      return { center: [lat, lon] as [number, number], zoom: 13 };
    }

    const bounds = new LatLngBounds([]);
    cellsWithCoords.forEach(cell => {
      const lat = cell.object!.address!.coordinates.lat;
      const lon = cell.object!.address!.coordinates.lon;
      bounds.extend(new LatLng(lat, lon));
    });

    const center = bounds.getCenter();


    let zoom = 4;

    const northEast = bounds.getNorthEast();
    const southWest = bounds.getSouthWest();
    const latDiff = Math.abs(northEast.lat - southWest.lat);
    const lngDiff = Math.abs(northEast.lng - southWest.lng);

    if (latDiff < 0.1 && lngDiff < 0.1) {
      zoom = 12;
    } else if (latDiff < 1 && lngDiff < 1) {
      zoom = 10;
    } else if (latDiff < 5 && lngDiff < 5) {
      zoom = 8;
    } else if (latDiff < 10 && lngDiff < 10) {
      zoom = 6;
    } else {
      zoom = 4;
    }

    return {
      center: [center.lat, center.lng] as [number, number],
      zoom
    };
  }, [cellsWithCoords]);

  return { center, zoom, cellsWithCoords };
};
