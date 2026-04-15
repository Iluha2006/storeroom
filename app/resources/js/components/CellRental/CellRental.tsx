import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';

import Layout from '@/_layout/Layout';
import { useGetCellPriceQuery } from '@/api/cellPriceApi';
import { useCellDetail } from '@/hooks/useCellDetail';
import { Tariff } from '@/types/Tariff';
import Loader from '@/UI/Loading/Loader';

const InfoRental = () => {
  const { cellSlug } = useParams<{ cellSlug: string }>();
  const { data: tariffs, isLoading, error } = useGetCellPriceQuery(cellSlug!);
  const [selectedTariff, setSelectedTariff] = useState<Tariff | null>(null);
  const { cell, loadCell } = useCellDetail();

  useEffect(() => {
    if (cellSlug) loadCell(cellSlug);
  }, [cellSlug, loadCell]);

  useEffect(() => {
    if (tariffs && !selectedTariff) {
      // eslint-disable-next-line react-hooks/set-state-in-effect
      setSelectedTariff(tariffs[0]);
    }
  }, [tariffs, selectedTariff]);

  const calculateFinalPrice = () => {
    return selectedTariff?.total || 0;
  };

  if (isLoading) {
    return(
        <Layout>
        <Loader>
        </Loader>
      </Layout>
    )

  }


  if (error || !tariffs || !cell) return <div className="text-center py-8 text-red-500">Ошибка загрузки</div>;

  return (
    <div className="max-w-6xl mx-auto px-4 py-8">
      <h1 className="text-2xl font-semibold mb-1">{cell.object.name}</h1>
      <p className="text-gray-500 mb-8">Аренда ячейки</p>

      <div className="grid md:grid-cols-2 gap-6">

        <div className="bg-white rounded-lg border p-6 h-96">
          <h2 className="text-lg font-medium mb-4 text-gray-900">Характеристики</h2>
          <div className="space-y-4 text-base ">
            <div className="flex justify-between">
              <span className="font-medium text-gray-900">Размеры:</span>
              <span className="text-gray-700">
                {cell.dimensions.length} × {cell.dimensions.width} × {cell.dimensions.height} м
              </span>
            </div>
            <div className="flex justify-between">
              <span className="font-medium text-gray-900">Объём:</span>
              <span className="text-gray-700">{cell.dimensions.volume} м³</span>
            </div>
            <div className="flex justify-between">
              <span className="font-medium text-gray-900">Этаж:</span>
              <span className="text-gray-700">{cell.position.floor || 1}</span>
            </div>
            <div className="flex justify-between">
              <span className="font-medium text-gray-900">Адрес:</span>
              <span className="text-gray-700 text-right ">
                {cell.object.address.full_address}
              </span>
            </div>
          </div>
        </div>
        <div className="bg-white rounded-lg border p-6">
          <h2 className="text-lg font-medium mb-4 text-gray-900">Срок аренды</h2>

          <div className="space-y-3 mb-6">
            {tariffs.map((t) => (
              <div
                key={t.months}
                className={`border rounded-lg p-4 cursor-pointer transition-colors ${
                  selectedTariff?.months === t.months
                    ? 'border-emerald-500 bg-emerald-50'
                    : 'hover:border-emerald-300'
                }`}
                onClick={() => setSelectedTariff(t)}
              >
                <div className="flex justify-between items-center">
                  <div>
                    <span className="font-medium text-gray-900">{t.months} мес.</span>
                    <span className="ml-3 text-emerald-600 font-medium">
                      {t.price.toLocaleString('ru-RU')} ₽/мес
                    </span>
                  </div>
                  {t.discount > 0 && (
                    <span className="text-sm text-emerald-600 font-medium">-{t.discount}%</span>
                  )}
                </div>
                <div className="text-sm text-gray-600 mt-1">
                  Итого: {t.total.toLocaleString('ru-RU')} ₽
                </div>
              </div>
            ))}
          </div>

          <div className="mb-6">
            <div className="text-sm text-gray-500 mb-2 font-medium">Способ оплаты</div>
            <div className="border rounded-lg p-3 bg-gray-50 text-base text-gray-700">
              Банковской картой
            </div>
          </div>

          <div className="border-t pt-4 mb-4">
            <div className="flex justify-between items-center">
              <span className="font-medium text-lg text-gray-900">К оплате:</span>
              <span className="text-xl font-semibold text-emerald-600">
                {calculateFinalPrice().toLocaleString('ru-RU')} ₽
              </span>
            </div>
          </div>

          <button
            className="w-full bg-emerald-600 text-white py-3 rounded-lg font-medium hover:bg-emerald-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed text-base"
            disabled={!selectedTariff}
          >
            Оформить аренду
          </button>


        </div>
      </div>
    </div>
  );
};

export default InfoRental;