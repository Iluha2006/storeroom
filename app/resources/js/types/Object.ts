import { IAddress } from "./adress";

export interface IWarehouseObject {
    id: number;
    uuid: string;
    address_id: number;
    organization_id: number;
    is_active: boolean;
    name: string;
    slug: string;
    description: string;
    address?: IAddress;
    cells_count?: number;
    created_at?: string;
    updated_at?: string;
}