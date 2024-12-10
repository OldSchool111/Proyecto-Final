import { Routes } from '@angular/router';
import { InicioComponent } from './componentes/inicio/inicio.component';
import { MiscelaneaComponent } from './componentes/miscelanea/miscelanea.component';
import { FormularioComponent } from './componentes/formulario/formulario.component';
import { authGuard } from './auth.guard';
import { InicioSesionComponentComponent } from './componentes/inicio-sesion/inicio-sesion.component';

export const routes: Routes = [
    {path:'',component:InicioComponent,canActivate:[authGuard]},
    {path:'inicio-sesion',component:InicioSesionComponentComponent},
    {path:'miscelanea',component:MiscelaneaComponent, canActivate:[authGuard]},
    {path:'formulario',component:FormularioComponent},
    {path:'disborard', component: InicioComponent},
];
