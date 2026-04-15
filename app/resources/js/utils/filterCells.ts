
import { ICell } from '@/types/Cell';

export const filterCellsWithCoordinates = (cells: ICell[]): ICell[] => {
  return cells.filter(cell => {
    const lat = cell.object?.address?.coordinates.lat;
    const lon = cell.object?.address?.coordinates?.lon;
    return typeof lat === 'number' && typeof lon === 'number';
  });
};