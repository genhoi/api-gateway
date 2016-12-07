using Microsoft.AspNetCore.Mvc;
using System.Threading.Tasks;
using System.Net.Http;
using System;

namespace Api.Controllers
{
    [Route("/")]
    public class RootController : Controller
    {

        [HttpGet]
        public async Task<string> GetHelloWorld()
        {
            var result = await Task.WhenAll(
                SendRequest("http://openresty_hello"),
                SendRequest("http://openresty_world")
            );


            return result[0] + ", " + result[1];
        }

        protected async Task<String> SendRequest(String url)
        {
            String stringResponse;
            using (var client = new HttpClient())
            {
                client.BaseAddress = new Uri(url);
                var response = await client.GetAsync("/");
                stringResponse = await response.Content.ReadAsStringAsync();
            }

            return stringResponse;
        }

    }

        
}