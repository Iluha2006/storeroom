export interface Tariff {
    months: number;
    price: number;
    discount: number;
    total: number;
  }

 export interface CellPriceResponse {
    success: boolean;
    tariffs: Record<string, Tariff>;
  }