import React, { } from 'react';
import { useParams, Link } from 'react-router-dom';

import Layout from '@/_layout/Layout';
//import { useCells } from '@/hooks/useCells';
import Loader from '@/UI/Loading/Loader';

import { useGetCellsByCitySlugQuery } from '../../api/cellApi';



const CityCells: React.FC = () => {
  const { citySlug } = useParams<{ citySlug: string, objectCity:string }>();
 // const { cells, loading,   loadCellsByCity } = useCells();
 const {
    data: cells =[], 
    isLoading,
  } = useGetCellsByCitySlugQuery(citySlug!, {
    skip: !citySlug, 
  });

  console.log("Данные одной ячейки ", cells)
  if (isLoading) {
    return (
      <Layout>
        <Loader>
        </Loader>
      </Layout>
    );
  }

  return (
    <Layout>
      <div className="max-w-7xl mx-auto px-4 py-8">
        <nav className="flex items-center space-x-2 text-sm text-gray-600 mb-8">
          <Link to="/" className="hover:text-emerald-600">Главная</Link>
          <span>/</span>
          <Link to="/city" className="hover:text-emerald-600">Города</Link>
          <span>/</span>

        </nav>


     <div>


     </div>

        <div className="mb-8">
          <h1 className="text-3xl font-bold text-gray-900 mb-2">

          </h1>
          <p className="text-gray-600">
            {cells.length} {cells.length === 1 ? 'ячейка' : 'ячеек'} доступно для хранения
          </p>
        </div>

        <div className="bg-white rounded-xl shadow-sm overflow-hidden">
          <div className="overflow-x-auto">
            <table className="min-w-full divide-y divide-gray-200">
              <thead className="bg-gray-50">
                <tr>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Название
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Адрес
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Телефон
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Режим работы
                  </th>

                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Цена
                  </th>
                  <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                    Действия
                  </th>
                </tr>
              </thead>
              <tbody className="bg-white divide-y divide-gray-200">
              {cells.map((cell) => (
                  <tr key={cell.uuid} className="hover:bg-gray-50 transition-colors">
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm font-medium text-gray-900">
                        {cell.object?.name }
                      </div>
                    </td>
                    <td className="px-6 py-4">
                      <div className="text-sm text-gray-900">
                       {cell.object.address.full_address }

                      </div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-900">
                       {cell.object?.organization?.phone}
                      </div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm text-gray-900">
                        Круглосуточно
                      </div>
                    </td>

                    <td className="px-6 py-4 whitespace-nowrap">
                      <div className="text-sm font-medium text-emerald-600">
                      { `${Number(cell.price.amount)} ₽` }



                      </div>
                    </td>
                    <td className="px-6 py-4 whitespace-nowrap text-sm font-medium">
                      <Link
                        to={`/cellObject/${cell.slug}`}
                        className="inline-flex items-center px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white text-sm font-medium rounded-lg transition-colors"
                      >
                        Выбрать
                      </Link>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>

          {cells.length === 0 && !isLoading && (
            <div className="text-center py-12">
              <div className="text-gray-500">Нет доступных ячеек в этом городе</div>
              <Link
                to="/city"
                className="mt-4 inline-block text-emerald-600 hover:text-emerald-800"
              >
                Вернуться к выбору города
              </Link>
            </div>
          )}
        </div>
      </div>
    </Layout>
  );
};

export default CityCells;