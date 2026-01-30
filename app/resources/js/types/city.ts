export interface ICity {
    id : number;
    uuid: string;
    is_active: boolean;
    name: string;
    slug: string;
    created_at?: string;
    updated_at?: string;
}

export interface ICitiesResponse {
    success: boolean;
    data: ICity[];
    message?: string;
}

export interface ICityResponse {
    success: boolean;
    arrayData?: ICity;
    data?: ICity;
    message?: string;
}

export interface ICityState {
    items: ICity[];
    currentCity: ICity | null;
    selectedCity: ICity | null;
    loading: boolean;
    error: string | null;
    successMessage: string | null;
}

