import { Component } from '@angular/core';
import { FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { RouterLink } from '@angular/router';
import { RouterOutlet } from '@angular/router';
import { AuthService } from '../../auth.service'; // Asegúrate de que el AuthService esté bien importado


@Component({
  selector: 'app-navegacion',
  standalone: true,
  imports: [ReactiveFormsModule, RouterLink, RouterOutlet], // Remueve AuthService de imports
  templateUrl: './navegacion.component.html',
  styleUrls: ['./navegacion.component.css']
})
export class NavegacionComponent {
  form: FormGroup;

  constructor(
    private http: HttpClient,
    private router: Router,
    private authService: AuthService // Inyecta correctamente AuthService
  ) {
    this.form = new FormGroup({
      idEmpleado: new FormControl(''),
      nombreEmpleado: new FormControl(''),
      correoEmpleado: new FormControl(''),
      passwordEmpleado: new FormControl('')
    });
  }

  // Método para manejar el cierre de sesión
  onLogout() {
    this.authService.logout(); // Llama al método logout del AuthService
  }


}
