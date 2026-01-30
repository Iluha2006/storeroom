
export interface IOrganization {
    uuid: string;
    name: string;
    full_name?: string;
    phone: string;
    email: string;
    status: {
      value: string;
      label: string;
    };
    type: {
      value: string;
      label: string;
    };
    requisites: {
      inn: string;
      kpp: string;
      ogrn: string;
    };
    address?: string;
    users_count?: number;
    created_at?: string;
    updated_at?: string;
  }