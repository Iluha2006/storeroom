import { ICity } from './city';


export interface IAddress {
    id?: number;
    uuid?: string;
    city_id: number;
    city?: ICity;
    is_active: boolean;
    slug: string;
    street: string;
    full_address:string,
    house: string;
    building: string;
    frame: string;
    lat: number;
    lon: number;
    how_to_get_there: string;
}