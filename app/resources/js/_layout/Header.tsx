
import { useNavigate, useParams , Link } from 'react-router-dom';


export default function Header( ){
    const navigate = useNavigate();
    const { citySlug} = useParams<{ citySlug: string }>();

    function navigateHome(){
        navigate('/');
    }
    return(

        <header className="bg-white border-b border-gray-200">
        <div className="container mx-auto px-4 py-4">
          <div className="flex flex-col md:flex-row md:items-center justify-between">
            <div className="mb-4 md:mb-0" onClick={navigateHome}>
              <h1 className="text-2xl font-bold text-gray-900">СкладХранение</h1>
            </div>
            <nav className="m-auto flex gap-20">
              <Link to={`/city/map/${citySlug}`} className="text-gray-700 hover:text-blue-600 font-medium">Города</Link>
              <a href="/" className="text-gray-700 hover:text-blue-600 font-medium">Главная</a>

              <a href="#" className="text-gray-700 hover:text-blue-600 font-medium">FAQ</a>
            </nav>
            <nav>
                <a href="">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
</svg>
                </a>
            </nav>
          </div>
        </div>
      </header>

    )
}
