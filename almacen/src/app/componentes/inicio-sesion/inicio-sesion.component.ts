import { Component } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms'
import { HttpClient } from '@angular/common/http';
import { RouterLink } from '@angular/router';
import { RouterOutlet } from '@angular/router';
import {Router} from '@angular/router';
import { from } from 'rxjs';
import { error } from 'console';
import { Token } from '@angular/compiler';



@Component({
  selector: 'app-inicio-sesion',
  standalone: true,
  imports: [RouterOutlet,ReactiveFormsModule,RouterLink],
  templateUrl: './inicio-sesion.component.html',
  styleUrl: './inicio-sesion.component.css'
})
export class InicioSesionComponentComponent {
  form:FormGroup;
      constructor(private http: HttpClient, private router: Router) {
      this.form = new FormGroup({ 
      correoEmpleado: new FormControl(''),
      passwordEmpleado: new FormControl('')

    });
  }
     
  onSubmit(){
    if (this.form.valid) {
      const datos = this.form.value;
      this.http.post<{ token: string }>('http://localhost:8000/api/login', datos)
      .subscribe({
        next: (respuesta) => {
          console.log('Datos enviados exitosamente', respuesta);
          localStorage.setItem('token' , respuesta.token);
          this.router.navigate(['/miscelanea']);

        },
        error: (error) => {
          console.log ('Error al enviar datos', error);

        }
      });
    } else {
      console.log('Formulario invalido');
    }
  }

}
