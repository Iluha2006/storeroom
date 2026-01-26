<<<<<<< HEAD

=======
// Интерфейс города
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
export interface ICity {
    uuid: string;
    is_active: boolean;
    name: string;
    slug: string;
    created_at?: string;
    updated_at?: string;
}

<<<<<<< HEAD

=======
// Интерфейс ответа от API для списка городов
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
export interface ICitiesResponse {
    success: boolean;
    data: ICity[];
    message?: string;
}

<<<<<<< HEAD

=======
// Интерфейс ответа от API для одного города
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
export interface ICityResponse {
    success: boolean;
    arrayData?: ICity;
    data?: ICity;
    message?: string;
}

<<<<<<< HEAD

=======
// Интерфейс состояния Redux
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
export interface ICityState {
    items: ICity[];
    currentCity: ICity | null;
    selectedCity: ICity | null;
    loading: boolean;
    error: string | null;
    successMessage: string | null;
}

<<<<<<< HEAD
=======
// Интерфейс для параметров запроса (если будут нужны)
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
export interface ICityQueryParams {
    page?: number;
    limit?: number;
    sort?: string;
    activeOnly?: boolean;
}

<<<<<<< HEAD
export interface ICityFormData {
    name: string;
    slug?: string;
    is_active?: boolean
}


export interface ICityWithObjectsResponse {
    success: boolean;
    city: ICity;
    objects: unknown;
    message?: string;
}
=======
// Интерфейс для создания/обновления города
export interface ICityFormData {
    name: string;
    slug?: string;
    is_active?: boolean;
}

// Интерфейс для ответа с объектами складов
export interface ICityWithObjectsResponse {
    success: boolean;
    city: ICity;
    objects: any; // Замените на конкретный тип объектов складов
    message?: string;
}
>>>>>>> 273a5dd0220baeb80179c36ad7b00eb510b2ad6c
