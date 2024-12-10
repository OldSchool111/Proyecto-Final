import { Component } from '@angular/core';
import { RouterOutlet } from '@angular/router';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { CabeceraComponent } from "./componentes/cabecera/cabecera.component";
import { NavegacionComponent } from "./componentes/navegacion/navegacion.component";
import { PieComponent } from "./componentes/pie/pie.component";
import { FormularioComponent } from "./componentes/formulario/formulario.component";
import { NavigationEnd }  from '@angular/router';
import { CommonModule } from '@angular/common';
import { from } from 'rxjs';
import { InicioSesionComponentComponent} from "./componentes/inicio-sesion/inicio-sesion.component";

@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, CabeceraComponent, NavegacionComponent, PieComponent, FormularioComponent, CommonModule, InicioSesionComponentComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'almacen';
  mostrarCabeceraYPie = true;

constructor(private router: Router) {
  this.router.events.subscribe((event) => {
    if (event instanceof NavigationEnd) {
      if (event.url === '/inicio' || event.url === '/') {
        this.mostrarCabeceraYPie = false;

      }else {
        this.mostrarCabeceraYPie = true;
      }
    }
  });
}
}

