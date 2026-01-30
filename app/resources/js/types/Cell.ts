
import { IWarehouseObject } from './Object';

export interface ICell {
  uuid: string;
  slug: string;
  status: {
    value: number;
    label: string;
  };
  position:IPosition;
  dimensions:IDimensions;
  price: {
    amount: number;
    formatted: string;
  };
  how_to_get_there: string;
  object: IWarehouseObject;
}


export interface IDimensions{
    length: number;
    height: number;
    width: number;
    volume: number;
}
export interface IPosition{
    floor: number;
    row: number;
    section: number;
    level: number;
    number: number;
    formatted: string;
}