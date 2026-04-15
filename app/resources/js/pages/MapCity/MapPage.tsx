//import { useEffect } from "react";

import Layout from "../../_layout/Layout";
import { useGetAllCellsQuery } from "../../api/cellApi";
import MapCellObjectCell from "../../components/MapCell/MapCellObjectCell";
//import { useCells } from "../../hooks/useCells";
const MapPage = () => {

const { data: cells = []}=  useGetAllCellsQuery();
  
  return (
    <Layout>
      <div className="max-w-7xl mx-auto px-4 py-8">
        <h1 className="text-3xl font-bold text-gray-900 mb-6">
          Карта всех ячеек
        </h1>
        <MapCellObjectCell cells={cells}/>
      </div>
    </Layout>
  );
};

export default MapPage;


