using System;
using Microsoft.AspNetCore.Hosting;
 
namespace Api
{
    public class Program
    {
        public static void Main(string[] args)
        {
            var host = new WebHostBuilder()
            .UseUrls("http://0.0.0.0:5000")
            .UseEnvironment("Production")
            .UseKestrel()
            .UseStartup<Startup>()
            .Build();
 
            host.Run();
        }
    }
}