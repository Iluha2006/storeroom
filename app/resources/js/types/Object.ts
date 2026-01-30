import { IAddress } from "./adress";
import { IOrganization } from "./organization";

export interface IWarehouseObject {
    id: number;
    uuid: string;
    address_id: number;
    organization_id: number;
    organization?: IOrganization;
    is_active: boolean;
    name: string;
    slug: string;
    description: string;
    address: IAddress;
    price: number;
    cells_count?: number;
    created_at?: string;
    updated_at?: string;
}