
import React from 'react';

interface CellActionButtonsProps {
  onDetailsClick: () => void;


}

const CellActionButtons: React.FC<CellActionButtonsProps> = ({
  onDetailsClick,
}) => {
  return (
    <div className="space-y-2">
      <button
        onClick={onDetailsClick}
        className="w-full px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-medium rounded-lg transition-colors text-sm"
      >
       Выбрать ячейку
      </button>
    </div>
  );
};

export default CellActionButtons;
