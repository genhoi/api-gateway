using Microsoft.AspNetCore.Mvc;

namespace Api.Controllers
{
    [Route("/")]
    public class RootController : Controller
    {

        [HttpGet]
        public string GetHelloWorld()
        {
            return "Hello, World";
        }

    }

        
}