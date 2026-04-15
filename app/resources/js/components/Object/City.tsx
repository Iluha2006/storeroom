
import React from 'react';
import {  Link } from 'react-router-dom';

import { useGetAllCellsQuery } from '@/api/cellApi';
import Loader from '@/UI/Loading/Loader';


const CELL_STATUS = {
  AVAILABLE: 10,
  RESERVED: 9,
  UNAVAILABLE: 8
} as const;


const CityList: React.FC = () => {
  const { data: cells = [], isLoading } = useGetAllCellsQuery();



  if (isLoading) {
    return <Loader />;
  }


  const getStatusColor = (statusValue: number): string => {
    switch (statusValue) {
      case CELL_STATUS.AVAILABLE:
        return 'bg-green-100 text-green-800 border-green-200';
      case CELL_STATUS.RESERVED:
        return 'bg-yellow-100 text-yellow-800 border-yellow-200';
      case CELL_STATUS.UNAVAILABLE:
        return 'bg-red-100 text-red-800 border-red-200';
      default:
        return 'bg-gray-100 text-gray-800 border-gray-200';
    }
  };


  const getStatusText = (statusValue: number): string => {
    switch (statusValue) {
      case CELL_STATUS.AVAILABLE:
        return 'Доступно';
      case CELL_STATUS.RESERVED:
        return 'Зарезервировано';
      case CELL_STATUS.UNAVAILABLE:
        return 'Недоступно';
      default:
        return 'Неизвестно';
    }
  };

  const getCellCountColor = (statusValue: number): string => {
    switch (statusValue) {
      case CELL_STATUS.AVAILABLE:
        return 'text-green-600';
      case CELL_STATUS.RESERVED:
        return 'text-yellow-600';
      case CELL_STATUS.UNAVAILABLE:
        return 'text-red-600';
      default:
        return 'text-gray-600';
    }
  };


  return (
    <div className="max-w-6xl mx-auto px-4 py-8">
      <div className="text-center mb-12">
        <h1 className="text-4xl font-bold text-gray-900 mb-4">
          Наши склады
        </h1>
        <p className="text-lg text-gray-600 max-w-2xl mx-auto">
          Выберите город и найдите удобное место для хранения ваших вещей
        </p>
      </div>


      {cells.length === 0 ? (
        <div className="text-center py-12">
          <p className="text-gray-500 text-lg">Нет доступных складов</p>
        </div>
      ) : (
        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {cells.map((city) => (
            <Link
              key={city.uuid}
              to={`/city/${city.object.address.city?.slug}`}
              className="group block p-6 bg-white rounded-xl shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200 hover:border-blue-200 hover:bg-blue-50/30"
            >

              <div className="flex items-center gap-2 mb-4">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  width="20"
                  height="20"
                  fill="currentColor"
                  className="text-green-500 group-hover:scale-110 transition-transform duration-300 flex-shrink-0"
                  viewBox="0 0 16 16"
                >
                  <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10"/>
                  <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6"/>
                </svg>
                <h3 className="text-xl font-semibold text-gray-800 group-hover:text-blue-600 transition-colors">
                  {city.object.address.city?.name }


                </h3>
              </div>


              {city.object.address.street && (
                <p className="text-sm text-gray-600 mb-4 pl-7">
                 Адрес: { city.object.address.full_address}
                </p>
              )}
              <div className="flex items-center justify-between pl-7">
                <div className="flex items-center gap-2">
                  <span className={`px-3 py-1 rounded-full text-sm font-medium border ${getStatusColor(city.status?.value)}`}>
                    {getStatusText(city.status?.value)}
                  </span>
                </div>

                <div className="flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-full">
                  <span className="text-sm font-medium text-gray-700">
                    Ячеек:
                  </span>
                  <span className={`text-lg font-bold ${getCellCountColor(city.status?.value)}`}>
                    {city.status?.value }
                  </span>
                </div>
              </div>

            </Link>
          ))}
        </div>
      )}

    </div>
  );
};

export default CityList;