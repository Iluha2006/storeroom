import { useSelector } from "react-redux";
import { useDispatch } from "react-redux";

import { fetchCellsByCity, fetchCellsShow } from "../store/CellObject";
import { AppDispatch, RootState } from "../store/store";


export const useCells = () => {
    const dispatch = useDispatch<AppDispatch>();

    const cellsSlice = useSelector((state: RootState) => {
      console.log('StateCell:', state);
      return state.cells || { cells: [], loading: false, error: null };
    });

    const { cells, loading } = cellsSlice;

    console.log('Cells in hook:', cells);

    const loadCellsByCity = (citySlug: string) => {
      return dispatch(fetchCellsByCity(citySlug));
    };

    const CellsByShow = (citySlug: string) => {
        return dispatch(fetchCellsShow(citySlug));
      };

    return { cells, loading, loadCellsByCity, CellsByShow };
  };